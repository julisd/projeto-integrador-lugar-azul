<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('avaliacoes_comentarios', function (Blueprint $table) {
        $table->increments('id');
        $table->unsignedBigInteger('usuario_id');
        $table->unsignedBigInteger('estabelecimento_id');
        $table->integer('avaliacao')->nullable();
        $table->text('comentario')->nullable();
        $table->timestamps();

        $table->foreign('usuario_id')->references('id')->on('pessoa_usuaria')->onDelete('cascade');
        $table->foreign('estabelecimento_id')->references('id')->on('estabelecimentos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_comentarios');
    }
};
