<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->unsignedBigInteger('persona_id');
            $table->unsignedBigInteger('pierna_dominante_id')->nullable();
            $table->unsignedBigInteger('posicionesId')->nullable(); // Aunque hay belongsToMany, también hay belongsTo
            $table->unsignedBigInteger('camisetasId')->nullable();

            // Estado
            $table->boolean('activo')->default(true);

            $table->timestamps();

            // Claves foráneas
            $table->foreign('persona_id')->references('id')->on('persona')->onDelete('cascade');
            $table->foreign('pierna_dominante_id')->references('id')->on('pierna_dominante')->nullOnDelete();
            $table->foreign('posicionesId')->references('id')->on('posiciones')->nullOnDelete();
            $table->foreign('camisetasId')->references('id')->on('camisetas')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jugadores');
    }
};
