<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoHemocomponente extends Model
{

    public $table = "t_tipo_hemocomponente";
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nombre_tipo_hemocomponente',
        'sigla_tipo_hemocomponente',
        'created_at',
        'updated_at',
        'IS_DELETE',
        'EMPRESA',
    ];

    #region

    public function unidadtransfusionalsapositivo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 1)
            ->where('tipo_rh_fk', 1);
    }
    public function unidadtransfusionalsanegativo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 1)
            ->where('tipo_rh_fk', 2);
    }

    public function unidadtransfusionalsbpositivo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 2)
            ->where('tipo_rh_fk', 1);
    }
    public function unidadtransfusionalsbnegativo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 2)
            ->where('tipo_rh_fk', 2);
    }

    public function unidadtransfusionalsabpositivo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 3)
            ->where('tipo_rh_fk', 1);
    }
    public function unidadtransfusionalsabnegativo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 3)
            ->where('tipo_rh_fk', 2);
    }

    public function unidadtransfusionalsopositivo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 4)
            ->where('tipo_rh_fk', 1);
    }
    public function unidadtransfusionalsonegativo(): HasMany
    {
        return $this->hasMany(UnidadTransfusional::class, 'tipo_hemocomponente_fk', 'id')
            ->where('IS_DELETE', 0)
            ->where('grupo_sanguineo_fk', 4)
            ->where('tipo_rh_fk', 2);
    }
    #endregion
}
