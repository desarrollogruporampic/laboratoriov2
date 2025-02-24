<?php

namespace App\Models;

use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BitacoraUnidad extends Model
{
    use HasFactory;
    use HasDrafts;

    public $table = "t_bitacora_unidad";
    public $timestamps = true;
    protected $primaryKey = 'id_bitacora_unidad';
    protected $fillable = [
        'id_bitacora_unidad',
        'unidad_transfusional_fk',
        'accion',
        'comentario',
        'user_genera',
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
        'unidadtransfusional',

    ];


    public function unidadtransfusional(): BelongsTo
    {
        return $this->belongsTo(UnidadTransfusional::class, 'unidad_transfusional_fk', 'id_unidad_transfusional')->with('tipohemocomponente');
    }
}
