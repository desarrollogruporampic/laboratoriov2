<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('t_fenotipos')) {
            Schema::table('t_fenotipos', function ($table) {
                $table->renameColumn('id_fenotipos', 'id_fenotipo');
                $table->renameColumn('nombre', 'nombre_fenotipo');
            });
            Schema::rename('t_fenotipos', 't_fenotipo');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
