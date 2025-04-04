<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Fenotipo extends Model
{

    public $table = "t_fenotipo";
    public $timestamps = true;
    protected $primaryKey = 'id_fenotipo';
    protected $fillable = [
        'id_fenotipo',
        'nombre_fenotipo',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA'
    ];

    public function unidadtransfusionalfenotipo()
    {
        return $this->hasMany(UnidadTransfusionalFenotipo::class, 'id_fenotipo', 'id_fenotipo');
    }
}
