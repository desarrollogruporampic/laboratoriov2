<?php

namespace App\Models;

use App\Enums\TipoAccion;
use App\Enums\TipoBitacoraUnidad;
use Guava\FilamentDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

class BitacoraUnidad extends Model
{
    use HasFactory;
    use HasDrafts;

    public $table = "t_bitacora_unidad";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'unidad_transfusional_fk',
        'tipo_bitacora',
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

    protected function casts(): array
    {
        return [
            'tipo_bitacora' => TipoAccion::class,
        ];
    }

    protected function nombreBitacora(): Attribute
    {
        return new Attribute(
            get: function (mixed $value) {
                Log::info($value);
            },
        );
    }

    public function unidadtransfusional(): BelongsTo
    {
        return $this->belongsTo(UnidadTransfusional::class, 'unidad_transfusional_fk', 'id')->with('tipohemocomponente', 'tiporh');
    }
}
