<?php

namespace App\Http\Controllers;

use App\Models\UnidadTransfusional;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            $unidad = UnidadTransfusional::where('tipo_hemocomponente_fk', $idTipoHemocomponente)->where('numero_componente', $number)->first();

            if ($unidad) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return '';
        }
    }
}
