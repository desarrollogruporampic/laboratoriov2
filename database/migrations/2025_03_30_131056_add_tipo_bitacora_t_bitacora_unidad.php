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
                $table->string('tipo_unidad', 100)->nullable()->after('unidad_transfusional_fk');
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
