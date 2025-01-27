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
        if (Schema::hasTable('t_grupo_sanguineo')) {
            Schema::table('t_grupo_sanguineo', function ($table) {
                $table->renameColumn('grupo', 'nombre_grupo_sanguineo');
            });
        }

        if (Schema::hasTable('t_tipo_hemocomponentes')) {
            Schema::table('t_tipo_hemocomponentes', function ($table) {
                $table->renameColumn('id_tipo_hemocomponentes', 'id_tipo_hemocomponente');
            });
            Schema::rename('t_tipo_hemocomponentes', 't_tipo_hemocomponente');
        }

        if (Schema::hasTable('t_unidad_transfusional')) {
            Schema::table('t_unidad_transfusional', function ($table) {
                $table->renameColumn('grupo_fk', 'grupo_sanguineo_fk');
                $table->renameColumn('fenotipos_nombre', 'nombre_fenotipo');
                $table->renameColumn('rh_fk', 'tipo_rh_fk');
            });
        }

        if (Schema::hasTable('t_entrada_unidad_detalle')) {
            Schema::table('t_entrada_unidad_detalle', function ($table) {
                $table->renameColumn('entarda_fk', 'entrada_unidad_fk');
                $table->renameColumn('unidad_fk', 'unidad_transfusional_fk');
                $table->renameColumn('tipo_fk', 'tipo_hemocomponente_fk');
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
