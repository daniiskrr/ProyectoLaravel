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
        Schema::create('oferta_suscripcion', function (Blueprint $table) {
            $table->integer('id_juego')->primary();
            $table->unsignedBigInteger('id_suscripcion');
            $table->unsignedBigInteger('id_oferta');
            
            $table->foreign('id_suscripcion')->references('id')->on('suscripcion');
            $table->foreign('id_oferta')->references('id')->on('oferta');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oferta_suscripcion');
    }
};
