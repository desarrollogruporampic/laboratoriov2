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
        if (Schema::hasTable('t_tipo_hemocomponente')) {
            Schema::table('t_tipo_hemocomponente', function ($table) {
                $table->renameColumn('nombre', 'nombre_tipo_hemocomponente');
                $table->renameColumn('siglas', 'sigla_tipo_hemocomponente');
            });
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
