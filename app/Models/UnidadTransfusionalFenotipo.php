<?php

namespace App\Models;

use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UnidadTransfusionalFenotipo extends Pivot
{
    /*  use HasDrafts; */

    public $table = "t_transfusional_fenotipo";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'id_unidad_transfusional',
        'id_fenotipo',
        'id_tipo_rh',
        'descripcion',
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
    ];

    protected array $draftableRelations = [
        'fenotipo',
        'tiporh',
        'unidadtransfusional',
    ];

    public function fenotipo()
    {
        return $this->belongsTo(Fenotipo::class, 'id', 'id_fenotipo');
    }
    public function tiporh()
    {
        return $this->belongsTo(TipoRh::class, 'id_tipo_rh', 'id');
    }

    public function unidadtransfusional()
    {
        return $this->belongsTo(UnidadTransfusional::class, 'id_unidad_transfusional', 'id')->with('fenotipo', 'tiporh')->where('IS_DELETE', 0);
    }


    /*   public function unidadtransfusional()
    {
        return $this->hasManyThrough(
            UnidadTransfusional::class,
            UnidadTransfusionalFenotipo::class,
            'id_unidad_transfusional',
            'id_fenotipo',
            'id_unidad_transfusional',
            'id_fenotipo'
        );
    } */
}
