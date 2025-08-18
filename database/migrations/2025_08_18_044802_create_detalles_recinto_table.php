<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('detalles_recinto', function (Blueprint $table) {
            $table->id();
            $table->string('ubicacion');
            $table->string('tipo_superficie');
            $table->integer('capacidad_espectadores');
            $table->boolean('graderias')->default(0);
            $table->boolean('vestidores')->default(0);
            $table->boolean('banos_publico')->default(0);
            $table->boolean('estacionamiento')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalles_recinto');
    }
};
