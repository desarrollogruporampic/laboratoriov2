<?php

namespace Database\Seeders;

use App\Models\TipoHemocomponente;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoHemocomponenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Globulos Rojos Empacados',
            'sigla_tipo_hemocomponente' => 'GRE',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Globulos Rojos Empacados Filtrados',
            'sigla_tipo_hemocomponente' => 'GREF',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Plasma Fresco Congelado',
            'sigla_tipo_hemocomponente' => 'PFC',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Plasma Fresco Descongelado',
            'sigla_tipo_hemocomponente' => 'PFD',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Plaquetas de Buffy Coat',
            'sigla_tipo_hemocomponente' => 'PKBC',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Pool de plaquetas de Buffy Coat filtradas',
            'sigla_tipo_hemocomponente' => 'PPkBC',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Plaquetas de aferesis filtradas',
            'sigla_tipo_hemocomponente' => 'PKAF',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Crioprecipitados',
            'sigla_tipo_hemocomponente' => 'CRIO',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $hemocomponente = TipoHemocomponente::create([
            'nombre_tipo_hemocomponente' => 'Pool de crioprecipitados',
            'sigla_tipo_hemocomponente' => 'PCRIO',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
