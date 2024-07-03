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
        Schema::create('tipo_servicos', function (Blueprint $table) {
            $table->id();
            $table->string('conserto');
            $table->string('revisão');
            $table->foreignId('mecanico_id')->constrainedTo('mecanicos');
            $table->foreignId('cliente_veiculo_id')->constrainedTo('cliente_veiculos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipo_servicos');
    }
};
