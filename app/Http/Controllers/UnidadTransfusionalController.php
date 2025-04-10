<?php

namespace App\Http\Controllers;

use App\Models\EntradaUnidad;
use App\Models\EntradaUnidadDetalle;
use App\Models\KardexUnidad;
use App\Models\UnidadTransfusional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mpdf\Mpdf;

class UnidadTransfusionalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UnidadTransfusional $unidadTransfusional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UnidadTransfusional $unidadTransfusional)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UnidadTransfusional $unidadTransfusional)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UnidadTransfusional $unidadTransfusional)
    {
        //
    }

    /**
     * Search the specified resource.
     */
    public static function searchNumberSerie($idTipoHemocomponente, $number)
    {
        if ($number) {
            $unidad = UnidadTransfusional::with('tipohemocomponente', 'gruposanguineo')
                ->where('tipo_hemocomponente_fk', $idTipoHemocomponente)
                ->where('numero_componente', $number)->first();

            if ($unidad) {
                return ['state' => 'success', 'unidad' => $unidad];
            } else {
                return ['state' => 'error', 'unidad' => null];
            }
        } else {
            return ['state' => '', 'unidad' => null];
        }
    }


    private static function crearEntradaDetalle($idEntradaUnidad, $idUnidadTransfusional, $comentario, $idBodega, $idTipoHemocomponente, $idUsuario, $empresa)
    {

        $detalle =  EntradaUnidadDetalle::create([
            'entrada_unidad_fk' => $idEntradaUnidad,
            'unidad_transfusional_fk' => $idUnidadTransfusional,
            'bodega_fk' => $idBodega,
            'comentario' => $comentario,
            'tipo_hemocomponente_fk' => $idTipoHemocomponente,
            'user_genera' => $idUsuario,
            'EMPRESA' => $empresa
        ]);

        return $detalle;
    }

    private static function crearKardexEntradaUnidad($idEntradaUnidad, $idUnidadTransfusional, $tipoAccion, $idBodega, $idUsuario, $empresa, $isSalida)
    {

        $kardex = KardexUnidad::create([
            'unidad_transfusional_fk' =>  $idUnidadTransfusional,
            'entrada_unidad_fk' => $idEntradaUnidad,
            'tipo_accion' => $tipoAccion,
            'bodega_fk' => $idBodega,
            'codigo_transaccion' => sprintf('%010d', $idEntradaUnidad),
            'is_salida' => $isSalida,
            'user_genera' => $idUsuario,
            'EMPRESA' =>  $empresa
        ]);
        return $kardex;
    }


    public static function publicarEntradaUnidad($unidad, $entrada)
    {
        $idEntradaUnidad = $entrada->id;
        $idUnidadTransfusional = $unidad->id;
        $idBodega = $unidad->bodega_fk;
        $idTipoHemocomponente = $unidad->tipo_hemocomponente_fk;
        $idUsuario = Auth::user()->id;
        $empresa = $entrada->EMPRESA;
        $tipoAccion = 'entrada';

        $detalle = self::crearEntradaDetalle($idEntradaUnidad, $idUnidadTransfusional, null, $idBodega, $idTipoHemocomponente, $idUsuario, $empresa);

        $kardex = self::crearKardexEntradaUnidad($idEntradaUnidad, $idUnidadTransfusional, $tipoAccion, $idBodega, $idUsuario, $empresa, 0);

        $unidad->withoutRevision()->update([
            'is_published' => 1,
            'published_at' => Carbon::now(),
        ]);
    }

    public static function sacarEntradaUnidad($bitacora, $entrada)
    {

        $idEntradaUnidad = $entrada->id;
        $idUnidadTransfusional = $bitacora->unidad_transfusional_fk;
        $idBodega = $bitacora->unidadtransfusional->bodega_fk;
        $idTipoHemocomponente = $bitacora->unidadtransfusional->tipo_hemocomponente_fk;
        $comentario = $bitacora->comentario;
        $idUsuario = Auth::user()->id;
        $empresa = $entrada->EMPRESA;
        $tipoAccion = 'salida';

        $detalle = self::crearEntradaDetalle($idEntradaUnidad, $idUnidadTransfusional, $comentario, $idBodega, $idTipoHemocomponente, $idUsuario, $empresa);

        $kardex = self::crearKardexEntradaUnidad($idEntradaUnidad, $idUnidadTransfusional, $tipoAccion, $idBodega, $idUsuario, $empresa, 1);

        $bitacora->unidadtransfusional()->update([
            'IS_DELETE' => 1,
        ]);
    }

    public function generarPDF($id)
    {

        // Datos que quieras pasar a la vista

        $data = EntradaUnidad::with('entradadetalle')->find($id);
        Log::info($data);
        // Renderizar la vista Blade
        $html = view('pdf.pdfHistorialEntradaUnidad', ['unidad' => $data])->render();

        // Crear el objeto mPDF
        $pdf = new Mpdf();

        // Escribir el contenido HTML en el PDF
        $pdf->WriteHTML($html);

        // Salvar el PDF o mostrarlo
        return $pdf->Output('mi_archivo.pdf', 'I'); // 'I' para mostrar en el navegador
    }
}
