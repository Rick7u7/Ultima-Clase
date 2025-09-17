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
            $table->foreignId('persona_id')->unique()->constrained('persona')->onDelete('cascade');
            $table->decimal('monto', 10, 2)->default(0);
            $table->enum('estado', ['pendiente', 'pagado', 'atrasado'])->default('pendiente');
            $table->timestamps();
        });           
    }

    public function down()
    {
        Schema::dropIfExists('saldo');
    }
};
