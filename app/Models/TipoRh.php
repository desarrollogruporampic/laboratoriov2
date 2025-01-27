<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRh extends Model
{
    use HasFactory;
    public $table = "t_tipo_rh";
    public $timestamps = true;
    protected $primaryKey = 'id_tipo_rh';
    protected $fillable = [
        'id_tipo_rh',
        'nombre_tipo_rh',
        'sigla_tipo_rh',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];
}
