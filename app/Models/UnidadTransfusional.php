<?php

namespace App\Models;

use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class UnidadTransfusional extends Model
{
    use HasDrafts;

    public $table = "t_unidad_transfusional";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'tipo_hemocomponente_fk',
        'numero_componente',
        'fecha_donacion',
        'fecha_caducidad',
        'fecha_entrada',
        'grupo_sanguineo_fk',
        'tipo_rh_fk',
        'bodega_fk',
        'is_fenotipo',
        'nombre_fenotipo',
        'user_registra',
        'estado',
        'comentario_salida',
        'fecha_salida',
        'user_salida',
        'fecha_salida',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
        'is_current',
        'is_published',
        'published_at',
        'uuid',
        'publisher_type',
        'publisher_id',
        /* ATRIBUTO TEMPORAL */
        /*    'list_fenotipo' */
    ];

    protected function casts(): array
    {
        return [
            /* 'list_fenotipo' => 'array', */
            'uuid' => 'string',
        ];
    }

    protected array $draftableRelations = [
        'tipohemocomponente',
        'gruposanguineo',
        'tiporh',
        'userentrada',
        'usersalida',
        'unidadtransfusionalfenotipo',
    ];

    public function tipohemocomponente()
    {
        return $this->belongsTo(TipoHemocomponente::class, 'tipo_hemocomponente_fk', 'id');
    }

    public function gruposanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'grupo_sanguineo_fk', 'id');
    }

    public function tiporh()
    {
        return $this->belongsTo(TipoRh::class, 'tipo_rh_fk', 'id');
    }
    public function bodegaalmacen()
    {
        return $this->belongsTo(BodegaAlmacen::class, 'bodega_fk', 'id_bodega_almacen');
    }

    public function userentrada()
    {
        return $this->belongsTo(User::class, 'user_registra', 'id');
    }

    public function usersalida()
    {
        return $this->belongsTo(User::class, 'user_salida', 'id');
    }
    /*
    public function unidadtransfusionalfenotipo()
    {
        return $this->hasManyThrough(UnidadTransfusional::class, UnidadTransfusionalFenotipo::class, 'id_unidad_transfusional', 'id_unidad_transfusional');
    }
 */
    public function kardex()
    {
        return $this->hasMany(KardexUnidad::class, 'unidad_transfusional_fk', 'id');
    }

    public function bitacora()
    {
        return $this->hasMany(BitacoraUnidad::class, 'unidad_transfusional_fk', 'id');
    }

    public function unidadtransfusionalfenotipo(): HasMany
    {
        return $this->hasMany(UnidadTransfusionalFenotipo::class, 'id_unidad_transfusional', 'id')->with('fenotipo', 'tiporh');
    }



    public static function boot()
    {
        parent::boot();
        static::created(function (UnidadTransfusional $unidad) {

            Log::info('ENTRA A CREAR LA BITACORA');
            Log::debug($unidad);

            BitacoraUnidad::create([
                'unidad_transfusional_fk' => $unidad['id'],
                'accion' => 25,
                'comentario' => 'Entrada de la unidad ' . $unidad['numero_componente'],
                'user_genera' =>  $unidad['user_registra'],
                'EMPRESA' =>  $unidad['EMPRESA']
            ]);

            /*  return $unidad; */
        });
    }
}
