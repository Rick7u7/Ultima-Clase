<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saldo', function (Blueprint $table) {
            $table->id();

            // Relación con persona (sin unique)
            $table->foreignId('persona_id')->constrained('persona')->onDelete('cascade');

            // Periodo de pago
            $table->unsignedTinyInteger('mes');  // 1–12
            $table->unsignedSmallInteger('año'); // Ej: 2025

            // Datos del saldo
            $table->decimal('monto', 10, 2)->default(0);
            $table->enum('estado', ['pendiente', 'pagado', 'atrasado'])->default('pendiente');

            // Timestamps
            $table->timestamps();

            // Índice único por persona y periodo
            $table->unique(['persona_id', 'mes', 'año'], 'saldo_persona_mes_anio_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('saldo');
    }
};

