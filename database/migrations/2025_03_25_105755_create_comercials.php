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
        Schema::create('comercials', function (Blueprint $table) {
            $table->id();
            $table->integer('propostasEnviadas');
            $table->integer('propostasFechadas');
            $table->integer('clientesNovos');
            $table->integer('renovacoes');
            $table->float('valorTotal');
            $table->string('competencia', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comercials');
    }
};
