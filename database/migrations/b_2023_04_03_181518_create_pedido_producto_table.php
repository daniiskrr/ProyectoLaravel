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
        Schema::create('pedido_producto', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pedido');
            $table->unsignedBigInteger('id_producto');
            $table->integer('linea');
            $table->unsignedBigInteger('id_oferta')->nullable();
            $table->integer('cantidad');
            $table->decimal('precio_unidad', 10, 2);
            $table->decimal('precio_descuento', 10, 2)->nullable();
            $table->timestamps();
            
            $table->primary(['id_pedido', 'id_producto']);
            $table->foreign('id_oferta')->references('id')->on('oferta');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_producto');
    }
};
