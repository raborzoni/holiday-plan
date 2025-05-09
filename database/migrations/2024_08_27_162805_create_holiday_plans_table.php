<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_plans', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->string('title'); // Título do plano de férias
            $table->text('description'); // Descrição do plano de férias
            $table->date('date'); // Data no formato YYYY-MM-DD
            $table->string('location'); // Localização do plano de férias
            $table->json('participants')->nullable(); // Participantes (opcional)
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('holiday_plans');
    }
};
