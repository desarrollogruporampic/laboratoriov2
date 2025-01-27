<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegaAlmacen extends Model
{
    public $table = 't_bodega_almacens';
    public $timestamps = false;
    protected $primaryKey = 'id_bodega_almacen';
    protected $fillable = [
        'id_bodega_almacen',
        'sucursal_fk',
        'nombre_bodega_almacen',
        'provicia_bodega_almacen',
        'canton_bodega_almacen',
        'distrito_bodega_almacen',
        'direccion_bodega_almacen',
        'status_bodega_almacen',
        'cuenta_contable_fk',
        'is_lab',
        'EMPRESA',
        'IS_DELETE',
    ];
}
