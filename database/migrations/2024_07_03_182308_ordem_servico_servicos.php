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
        Schema::create('ordem_servico_servicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_servico_servico_id')->constrained('ordem_servico_servicos');
            $table->foreignId('servico_id')->constrained('servicos');
            $table->string('autorizacao');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordem_servico_servico_servicos');;
    }
};
