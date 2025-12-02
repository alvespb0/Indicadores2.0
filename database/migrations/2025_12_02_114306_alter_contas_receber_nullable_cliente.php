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
        Schema::table('contas_receber_diario', function (Blueprint $table) {
            $table->string('cliente_uuid')->nullable()->change();
            $table->string('cliente_nome')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contas_receber_diario', function (Blueprint $table) {
            $table->string('cliente_uuid')->nullable(false)->change();
            $table->string('cliente_nome')->nullable(false)->change();
        });
    }
};
