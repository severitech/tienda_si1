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
    Schema::create('descuentos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre'); // Ej: "Descuento de Verano", "Oferta 2x1 Agua Vital"
        $table->text('descripcion')->nullable();
        // El tipo de descuento es crucial para la lógica
        $table->enum('tipo', ['fijo', 'porcentaje', '2x1', 'nxm'])->default('fijo');
        $table->decimal('valor', 8, 2); // Para 'fijo' (Bs.) o 'porcentaje' (%)
        $table->integer('condicion_n')->nullable(); // Para ofertas N+M (ej. "compra 3...")
        $table->integer('regalo_m')->nullable(); // Para ofertas N+M (ej. "...llévate 1 gratis")
        $table->boolean('activo')->default(true); // Para activar/desactivar ofertas
        $table->timestamp('fecha_inicio')->nullable();
        $table->timestamp('fecha_fin')->nullable();
        $table->timestamps();
        });

        // Tabla pivote para asignar descuentos a productos específicos
    // Esto te da la flexibilidad de que una oferta aplique a uno o varios productos.
    Schema::create('descuento_producto', function (Blueprint $table) {
        $table->foreignId('descuento_id')->constrained()->onDelete('cascade');
        $table->foreignId('producto_id')->constrained()->onDelete('cascade');
        $table->primary(['descuento_id', 'producto_id']);
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuentos');
    }
};
