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
        Schema::create('usuario_suscripcion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_suscripcion');
            $table->date('inicio');
            $table->date('fin');
            
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->foreign('id_suscripcion')->references('id')->on('suscripcion');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_suscripcion');
    }
};
