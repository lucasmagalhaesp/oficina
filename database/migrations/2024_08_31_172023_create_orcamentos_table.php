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
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->increments("id");
            $table->string("cliente", 100);
            $table->string("vendedor", 100);
            $table->text("descricao");
            $table->double("valor");
            $table->dateTime("data_hora_criacao");
            $table->softDeletes("data_hora_exclusao");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
