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
        Schema::create('projecao_contas_receber', function (Blueprint $table) {
            $table->id();
            $table->string('uuid', 255)->unique();
            $table->string('descricao', 255); # venda e RPS
            $table->date('data_vencimento');
            $table->string('status');
            $table->float('valor');
            $table->string('cliente_uuid', 255);
            $table->string('cliente_nome');
            $table->date('data_competencia'); # específica, yyyy-mm-dd; não será usado data_vencimento, pode ser que o vencimento seja para data x mas o cliente pagou antes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projecao_contas_receber');
    }
};
