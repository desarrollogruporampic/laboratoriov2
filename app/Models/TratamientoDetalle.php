<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TratamientoDetalle extends Model
{
    use HasFactory;
    public $table = "t_tratamiento_detalle";
    protected $primaryKey = 'id_tratamiento_detalle';
    protected $fillable = [
        'id_tratamiento_detalle',
        'tratamiento_fk',
        'is_muestra_externa',
        'doctor_refiere_fk',
        'examen_fk',
        "is_asap",
        "IS_STAT",
        'orden_fk',
        'usuario_modificacion_fk',
        'nombre_tratamiento_detalle',
        'numero_tratamiento_detalle',
        'fecha_aplicacion_individual',
        'ubicacion_filtro_fk',
        'completada',
        'anulada',
        "verificada",
        "referir",
        'is_asap',
        'motivo_suspension',
        'created_at',
        'updated_at',
        'motivo_cancelacion',
        'IS_DELETE',
        'EMPRESA',
        'lab_referir_fk',
        'orden_referir',
        'fecha_referir',
        'user_referir',
        'is_guardado'
    ];
}
