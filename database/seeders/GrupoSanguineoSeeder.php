<?php

namespace Database\Seeders;

use App\Models\GrupoSanguineo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoSanguineoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grupo = GrupoSanguineo::create([
            'nombre_grupo_sanguineo' => 'A',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $grupo = GrupoSanguineo::create([
            'nombre_grupo_sanguineo' => 'B',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $grupo = GrupoSanguineo::create([
            'nombre_grupo_sanguineo' => 'AB',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $grupo = GrupoSanguineo::create([
            'nombre_grupo_sanguineo' => 'O',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
