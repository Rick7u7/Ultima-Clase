<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pierna_dominante', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); // Evita duplicados como "Derecha", "Izquierda"
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pierna_dominante');
    }
};
