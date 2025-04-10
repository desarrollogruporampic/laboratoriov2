<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class EntradaUnidad extends Model
{

    use HasFactory;

    public $table = "t_entrada_unidad";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'bodega_fk',
        'tipo_unidad',
        'user_genera',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];


    public function entradadetalle()
    {
        return $this->hasMany(EntradaUnidadDetalle::class, 'entrada_unidad_fk', 'id')
            ->where('IS_DELETE', 0)
            ->with(['unidadtransfusional', 'tipohemocomponente', 'bodegaalmacen']);
    }

    public function bodegaalmacen()
    {
        return $this->belongsTo(BodegaAlmacen::class, 'bodega_fk', 'id_bodega_almacen');
    }

    public function usercrea()
    {
        return $this->belongsTo(User::class, 'user_genera', 'id');
    }
}
