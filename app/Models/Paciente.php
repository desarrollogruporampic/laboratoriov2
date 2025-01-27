<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    public $table = "t_paciente";
    public $timestamps = false;
    protected $primaryKey = 'paciente_id';
    protected $fillable = [
        'paciente_id',
        'cliente_fk',
        'nombre',
        'apellido_1',
        'apellido_2',
        'tipo_identificacion',
        'cedula',
        'conocidocomo_paciente',
        'nombrepadre_paciente',
        'nombremadre_paciente',
        'pais_paciente',
        'provincia_paciente',
        'canton_paciente',
        'distrito_paciente',
        'fecha_nacimiento',
        'telefono',
        'telefono2_paciente',
        'correo',
        'direccion',
        'estatura_paciente',
        'peso_paciente',
        'sexo_paciente',
        'estado_paciente',
        'familia_animal_paciente',
        'especie_paciente',
        'raza_paciente',
        'ocupacion_paciente',
        'estadocivil_paciente',
        'referencia_paciente',
        'foto_paciente',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];
}
