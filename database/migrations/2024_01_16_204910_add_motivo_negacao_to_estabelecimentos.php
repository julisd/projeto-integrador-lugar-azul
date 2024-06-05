<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoNegacaoToEstabelecimentos extends Migration
{
    public function up()
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            $table->text('motivo_negacao')->nullable();
        });
    }

    public function down()
    {
        Schema::table('estabelecimentos', function (Blueprint $table) {
            $table->dropColumn('motivo_negacao');
        });
    }
}
