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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->text('nome')->nullable();
            $table->text('email')->nullable();
            $table->text('cpf')->nullable();
            $table->text('cep')->nullable();
            $table->text('logradouro')->nullable();
            $table->text('complemento')->nullable();
            $table->text('bairro')->nullable();
            $table->text('localidade')->nullable();
            $table->text('uf')->nullable();
            $table->text('ibge')->nullable();
            $table->text('ddd')->nullable();
            $table->tinyInteger('ativo');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
