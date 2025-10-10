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
        Schema::create('exames', function (Blueprint $table) {
            $table->id();
            $table->integer('clinicos');
            $table->integer('audiometrias');
            $table->integer('laboratoriais');
            $table->integer('raiox');
            $table->integer('ecg');
            $table->integer('eeg');
            $table->integer('acuidade');
            $table->integer('espirometria');
            $table->date('competencia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exames');
    }
};
