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
        if (Schema::hasTable('t_bitacora_unidad')) {
            Schema::table('t_bitacora_unidad', function ($table) {
                $table->renameColumn('id_bitacora_unidad', 'id');
            });
        }

        if (Schema::hasTable('t_entrada_unidad')) {
            Schema::table('t_entrada_unidad', function ($table) {
                $table->renameColumn('id_entrada_unidad', 'id');
            });
        }

        if (Schema::hasTable('t_entrada_unidad_detalle')) {
            Schema::table('t_entrada_unidad_detalle', function ($table) {
                $table->renameColumn('id_entrada_unidad_detalle', 'id');
            });
        }

        if (Schema::hasTable('t_fenotipo')) {
            Schema::table('t_fenotipo', function ($table) {
                $table->renameColumn('id_fenotipo', 'id');
            });
        }

        if (Schema::hasTable('t_grupo_sanguineo')) {
            Schema::table('t_grupo_sanguineo', function ($table) {
                $table->renameColumn('id_grupo_sanguineo', 'id');
            });
        }

        if (Schema::hasTable('t_tipo_hemocomponente')) {
            Schema::table('t_tipo_hemocomponente', function ($table) {
                $table->renameColumn('id_tipo_hemocomponente', 'id');
            });
        }

        if (Schema::hasTable('t_tipo_rh')) {
            Schema::table('t_tipo_rh', function ($table) {
                $table->renameColumn('id_tipo_rh', 'id');
            });
        }

        if (Schema::hasTable('t_unidad_transfusional')) {
            Schema::table('t_unidad_transfusional', function ($table) {
                $table->renameColumn('id_unidad_transfusional', 'id');
            });
        }

        if (Schema::hasTable('t_transfusional_fenotipo')) {
            Schema::table('t_transfusional_fenotipo', function ($table) {
                $table->renameColumn('id_transfusional_fenotipo', 'id');
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
