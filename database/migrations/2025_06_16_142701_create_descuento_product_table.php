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
        Schema::create('descuento_product', function (Blueprint $table) {
            $table->foreignId('descuento_id')->constrained('descuentos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('PRODUCTO')->onDelete('cascade');
            $table->primary(['descuento_id', 'producto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('descuento_product');
    }
};
