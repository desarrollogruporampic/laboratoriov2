<?php

namespace Database\Seeders;

use App\Models\Fenotipo;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoFenotiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'C',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'c',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'E',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'e',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'CW',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $fenotipos = Fenotipo::create([
            'nombre_fenotipo' => 'K',
            'IS_DELETE' => 0,
            'EMPRESA' => 0,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
