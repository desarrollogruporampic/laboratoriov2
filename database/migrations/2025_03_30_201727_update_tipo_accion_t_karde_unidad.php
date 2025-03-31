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
        if (Schema::hasTable('t_kardex_unidad')) {
            Schema::table('t_kardex_unidad', function ($table) {
                $table->renameColumn('cod_tras', 'codigo_transaccion');
                $table->renameColumn('unidad_fk', 'unidad_transfusional_fk');
                $table->renameColumn('entrada_fk', 'entrada_unidad_fk');
                $table->dropColumn('salida_fk');
                $table->string('tipo_accion', 100)->nullable()->after('id_kardex_unidad');
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
