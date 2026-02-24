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
        Schema::table('exames', function (Blueprint $table) {
            $table->integer('toxicologico')->nullable();
            $table->integer('avap')->nullable();
            $table->integer('ava_med')->nullable();
            $table->dropColumn('outros_exames');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exames', function (Blueprint $table) {
            $table->dropColumn(['toxicologico', 'avap', 'ava_med']);
            $table->string('outros_exames')->nullable();
        });
    }
};
