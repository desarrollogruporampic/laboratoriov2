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
        if (Schema::hasTable('t_entrada_unidad_detalle')) {
            Schema::table('t_entrada_unidad_detalle', function ($table) {
                $table->string('comentario', 1000)->nullable()->after('tipo_hemocomponente_fk');
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
