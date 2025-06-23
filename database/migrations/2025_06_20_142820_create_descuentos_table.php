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
        Schema::create('DESCUENTOS', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NOMBRE');
            $table->text('DESCRIPCION')->nullable();
            $table->enum('TIPO', ['fijo', 'porcentaje', '2x1', 'nxm'])->default('fijo');
            $table->decimal('VALOR', 8, 2);
            $table->integer('CONDICION_N')->nullable();
            $table->integer('REGALO_M')->nullable();
            $table->boolean('ACTIVO')->default(true);
            $table->timestamp('FECHA_INICIO')->nullable();
            $table->timestamp('FECHA_FIN')->nullable();
            $table->timestamps();
        });

        // Tabla pivote para asignar descuentos a productos específicos
        // Esto te da la flexibilidad de que una oferta aplique a uno o varios productos.
        Schema::create('descuento_producto', function (Blueprint $table) {
            $table->unsignedBigInteger('DESCUENTO');
            $table->unsignedBigInteger('PRODUCTO');
            $table->primary(['DESCUENTO', 'PRODUCTO']);
            $table->foreign('DESCUENTO')->references('ID')->on('DESCUENTOS')->onDelete('cascade');
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
