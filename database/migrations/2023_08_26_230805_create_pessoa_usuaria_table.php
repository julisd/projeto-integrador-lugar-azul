<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePessoaUsuariaTable extends Migration
{
    public function up()
    {
        Schema::create('pessoa_usuaria', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->date('birthdate');
            $table->string('autism_characteristics')->nullable(); // Adiciona a coluna de características autistas, marcada como nullable
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pessoa_usuaria');
    }
}
