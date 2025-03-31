<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntradaUnidadDetalle extends Model
{
    public $table = "t_entrada_unidad_detalle";
    public $timestamps = true;
    protected $primaryKey = 'id_entrada_unidad_detalle';
    protected $fillable = [
        'id_entrada_unidad_detalle',
        'entrada_unidad_fk',
        'unidad_transfusional_fk',
        'bodega_fk',
        'tipo_hemocomponente_fk',
        'comentario',
        'user_genera',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];

    public function entradaunidad()
    {
        return $this->belongsTo(EntradaUnidad::class, 'entrada_unidad_fk', 'id_entrada_unidad');
    }

    public function unidadtransfusional()
    {
        return $this->belongsTo(UnidadTransfusional::class, 'unidad_transfusional_fk', 'id_unidad_transfusional')->with('gruposanguineo', 'tiporh');
    }
    public function tipohemocomponente()
    {
        return $this->belongsTo(TipoHemocomponente::class, 'tipo_hemocomponente_fk', 'id_tipo_hemocomponente');
    }

    public function bodegaalmacen()
    {
        return $this->belongsTo(BodegaAlmacen::class, 'bodega_fk', 'id_bodega_almacen');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_genera', 'id');
    }
}
