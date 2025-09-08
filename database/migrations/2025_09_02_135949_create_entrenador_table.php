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
        Schema::create('entrenador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->unique()->constrained('persona')->onDelete('cascade');
            $table->string('nivel');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrenador');
    }
};
