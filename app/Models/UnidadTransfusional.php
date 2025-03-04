<?php

namespace App\Models;

use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnidadTransfusional extends Model
{
    use HasDrafts;

    public $table = "t_unidad_transfusional";
    public $timestamps = true;
    protected $primaryKey = 'id_unidad_transfusional';
    protected $fillable = [
        'id_unidad_transfusional',
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
        'comentario_salida',
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
        'list_fenotipo'
    ];

    protected function casts(): array
    {
        return [
            'list_fenotipo' => 'array',
            'uuid' => 'string',
        ];
    }

    protected array $draftableRelations = [
        'tipohemocomponente',
        'gruposanguineo',
        'tiporh',
        'userentrada',
        'usersalida',
        /*  'unidadtransfusionalfenotipo', */
    ];

    public function tipohemocomponente()
    {
        return $this->belongsTo(TipoHemocomponente::class, 'tipo_hemocomponente_fk', 'id_tipo_hemocomponente');
    }

    public function gruposanguineo()
    {
        return $this->belongsTo(GrupoSanguineo::class, 'grupo_sanguineo_fk', 'id_grupo_sanguineo');
    }

    public function tiporh()
    {
        return $this->belongsTo(TipoRh::class, 'tipo_rh_fk', 'id_tipo_rh');
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

    public function unidadtransfusionalfenotipo(): HasMany
    {
        return $this->hasMany(UnidadTransfusionalFenotipo::class, 'id_unidad_transfusional', 'id_unidad_transfusional')->with('fenotipo', 'tiporh');
    }
}
