<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaUnidad extends Model
{
    use HasFactory;

    public $table = "t_entrada_unidad";
    public $timestamps = true;
    protected $primaryKey = 'id_entrada_unidad';
    protected $fillable = [
        'id_entrada_unidad',
        'bodega_fk',
        'user_genera',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];
}
