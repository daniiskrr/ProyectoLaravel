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
            $table->id();
            $table->unsignedBigInteger('id_suscripcion');
            $table->string('nombre_producto', 50);
            $table->decimal('precio_unidad', 10, 2);
            $table->string('imagen', 100);
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
