<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHemocomponente extends Model
{



    public $table = "t_tipo_hemocomponente";
    public $timestamps = true;
    protected $primaryKey = 'id_tipo_hemocomponente';
    protected $fillable = [
        'id_tipo_hemocomponente',
        'nombre_tipo_hemocomponente',
        'sigla_tipo_hemocomponente',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];
}
