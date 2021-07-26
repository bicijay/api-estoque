<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importacoes', function (Blueprint $table) {
            $table->string("importacao_uid")->primary();
            $table->string("operacao_uid", 50);
            $table->string("arquivo_uid", 50);
            $table->string("status", 50)->nullable();
            $table->text("status_descricao")->nullable();
            $table->timestamp("inicio_em")->nullable();
            $table->timestamp("fim_em")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('importacoes');
    }
}
