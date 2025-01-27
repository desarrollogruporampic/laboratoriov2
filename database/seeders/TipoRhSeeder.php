<?php

namespace Database\Seeders;

use App\Models\TipoRh;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoRhSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipoRh::create([
            'nombre_tipo_rh' => 'Positivo (+)',
            'sigla_tipo_rh' => '+',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        TipoRh::create([
            'nombre_tipo_rh' => 'Negativo (-)',
            'sigla_tipo_rh' => '-',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        /*  $tiposRh = [
            ['descripcion' => 'A+', 'abreviatura' => 'A+'],
            ['descripcion' => 'A-', 'abreviatura' => 'A-'],
            ['descripcion' => 'B+', 'abreviatura' => 'B+'],
            ['descripcion' => 'B-', 'abreviatura' => 'B-'],
            ['descripcion' => 'AB+', 'abreviatura' => 'AB+'],
            ['descripcion' => 'AB-', 'abreviatura' => 'AB-'],
            ['descripcion' => 'O+', 'abreviatura' => 'O+'],
            ['descripcion' => 'O-', 'abreviatura' => 'O-'],
        ];

        foreach ($tiposRh as $tipoRh) {
            \App\Models\TipoRh::create($tipoRh);
        } */
    }
}
