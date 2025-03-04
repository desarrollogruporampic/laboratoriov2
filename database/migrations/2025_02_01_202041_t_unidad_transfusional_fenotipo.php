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
        if (!Schema::hasTable('t_transfusional_fenotipo')) {
            Schema::create('t_transfusional_fenotipo', function (Blueprint $table) {
                $table->increments('id_transfusional_fenotipo');
                $table->integer('id_unidad_transfusional')->default(0);
                $table->integer('id_fenotipo')->default(0);
                $table->integer('id_tipo_rh')->default(0);
                $table->string('descripcion')->nullable();
                $table->integer('IS_DELETE')->default(0);
                $table->integer('EMPRESA')->default(0);
                $table->timestamps();
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
