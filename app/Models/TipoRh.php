<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoRh extends Model
{

    use HasFactory;
    public $table = "t_tipo_rh";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nombre_tipo_rh',
        'sigla_tipo_rh',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];


    public function unidadtransfusionalfenotipo()
    {
        return $this->hasMany(UnidadTransfusionalFenotipo::class, 'id_tipo_rh', 'id');
    }
}
