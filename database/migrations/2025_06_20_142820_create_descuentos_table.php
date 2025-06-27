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
        // Tabla principal para almacenar los descuentos y ofertas
        Schema::create('descuento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->enum('tipo', ['fijo', 'porcentaje', '2x1', 'nxm'])->default('fijo');
            $table->decimal('valor', 8, 2);
            $table->integer('condicion_n')->nullable();
            $table->integer('regalo_m')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('fecha_inicio')->nullable();
            $table->timestamp('fecha_fin')->nullable();
            $table->timestamps();
        });

        // Tabla pivote para asignar descuentos a productos específicos
        // Esto te da la flexibilidad de que una oferta aplique a uno o varios productos.
        Schema::create('descuento_producto', function (Blueprint $table) {
            $table->unsignedBigInteger('DESCUENTO');
            $table->unsignedBigInteger('PRODUCTO');
            $table->primary(['DESCUENTO', 'PRODUCTO']);
            $table->foreign('DESCUENTO')->references('ID')->on('descuento')->onDelete('cascade');
            $table->foreign('PRODUCTO')->references('ID')->on('PRODUCTO')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_producto');
        Schema::dropIfExists('DESCUENTOS');
    }
};
