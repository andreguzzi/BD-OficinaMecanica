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
        Schema::create('ordem_servicos_pecas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peca_id')->constrained('pecas');
            $table->foreignId('ordem_servico_id')->constrained('ordem_servicos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropTable('ordem_servicos_pecas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peca_id')->constrained('pecas');
            $table->foreignId('ordem_servico_id')->constrained('ordem_servicos');
        });
    }
};
