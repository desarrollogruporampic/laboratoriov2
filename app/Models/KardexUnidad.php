<?php

namespace App\Models;

use App\Enums\TipoAccion;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KardexUnidad extends Model
{
    public $table = "t_kardex_unidad";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tipo_accion',
        'unidad_transfusional_fk',
        'entrada_unidad_fk',
        'bodega_fk',
        'codigo_transaccion',
        'is_salida',
        'user_genera',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];

    protected function casts(): array
    {
        return [
            'tipo_accion' => TipoAccion::class,
        ];
    }
}
