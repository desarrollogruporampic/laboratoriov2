<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class GrupoSanguineo extends Model
    {
        public $table = "t_grupo_sanguineo";
        public $timestamps = true;
        protected $primaryKey = 'id_grupo_sanguineo';
        protected $fillable = [
            'id_grupo_sanguineo',
            'nombre_grupo_sanguineo',
            'created_at',
            'updated_at',
            'IS_DELETE',
            'EMPRESA',
        ];
    }
