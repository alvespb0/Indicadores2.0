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
        Schema::create('segurancas', function (Blueprint $table) {
            $table->id();
            $table->integer('levantamentoRealizados');
            $table->integer('treinamentosRealizados');
            $table->integer('laudosVendidos');
            $table->integer('laudosEmitidos');
            $table->string('competencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('segurancas');
    }
};
