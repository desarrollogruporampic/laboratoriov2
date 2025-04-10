<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class GrupoSanguineo extends Model
    {
        public $table = "t_grupo_sanguineo";
        public $timestamps = true;
        protected $primaryKey = 'id';
        protected $fillable = [
            'id',
            'nombre_grupo_sanguineo',
            'created_at',
            'updated_at',
            'IS_DELETE',
            'EMPRESA',
        ];
    }
