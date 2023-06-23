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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('cpf');
            $table->integer('idInstituicao');
            $table->string('instituicaoFinanceira');
            $table->string('modalidadeCredito');
            $table->string('codModalidade');
            $table->double('valorAPagar', 10, 2);
            $table->double('valorSolicitado', 10, 2);
            $table->decimal('taxaJuros', 5, 4);
            $table->integer('qntParcelas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
