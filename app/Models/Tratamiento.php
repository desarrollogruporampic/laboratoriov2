<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    use HasFactory;

    public $table = "t_tratamiento";
    protected $primaryKey = 'id_tratamiento';
    protected $fillable = [
        'id_tratamiento',
        'orden',
        'paciente_fk',
        'doctor_fk',
        'doctor_refiere_fk',
        'is_paquete',
        'paquete_fk',
        'cita_fk',
        'tipo',
        'paciente',
        'cedula_paciente',
        'usuario_modificacion_fk',
        'usuario_modificado_agenda_fk',
        'usuario_modificado_farmacia_fk',
        'usuario_modificado_laboratorio_fk',
        'dr_referencia',
        'lugar_referencia',
        'is_stat',
        'IS_ASAP',
        'tipo_tratamiento_fk',
        'revaloracion_fk',
        'tratamiento_periodo_fk',
        'tratamiento_periodo_valor',
        'tratamiento_interalo_fk',
        'tratamiento_interalo_valor',
        'accion_tratamiento',
        'completada',
        'examen_fk',
        'anulada',
        'IS_AGENDADO',
        'IS_AGENDADO_RX',
        'motivo_suspension',
        'descripcion_tratamiento',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
        'usuario_fk',
        'fecha_aplicacion'
    ];

    public function pacientefk()
    {
        return $this->belongsTo(Paciente::class, 'paciente_fk', 'paciente_id');
    }
}
