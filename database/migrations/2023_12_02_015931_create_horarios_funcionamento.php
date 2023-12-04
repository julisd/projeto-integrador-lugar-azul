<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios_estabelecimento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estabelecimento_id')->constrained('estabelecimentos');
            $table->string('dia_semana'); // Pode ser um número (1 a 7) ou string (segunda-feira, terça-feira, etc.)
            $table->time('abertura');
            $table->time('fechamento');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios_estabelecimento');
    }
};
