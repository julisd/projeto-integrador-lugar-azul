<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estabelecimento_id'); // Chave estrangeira para associar ao estabelecimento
            $table->string('cep', 9);
            $table->string('logradouro');
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro');
            $table->string('cidade');
            $table->string('uf', 2);
            
            $table->timestamps();

            // Chave estrangeira com ON DELETE CASCADE
            $table->foreign('estabelecimento_id')
                  ->references('id')->on('estabelecimentos')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
