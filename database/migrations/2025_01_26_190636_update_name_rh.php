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
        if (Schema::hasTable('t_rh')) {
            Schema::table('t_rh', function ($table) {
                $table->renameColumn('id_rh', 'id_tipo_rh');
                $table->renameColumn('nombre', 'nombre_tipo_rh');
                $table->renameColumn('siglas', 'sigla_tipo_rh');
            });
            Schema::rename('t_rh', 't_tipo_rh');
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
