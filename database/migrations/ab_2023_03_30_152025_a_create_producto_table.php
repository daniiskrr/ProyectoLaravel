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
        Schema::create('producto', function (Blueprint $table) {
            $table->id(); //ya tiene autoincrement
            $table->string('nombre');
            $table->longText('descripcion')->nullable(); //para que no sea obligatorio
            $table->unsignedBigInteger('id_suscripcion');
            $table->string('image');
            $table->double('precio');
            $table->timestamps();

            $table->foreign('id_suscripcion')->references('id')->on('suscripcion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
