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
        Schema::create('DETALLE_COMPRA', function (Blueprint $table) {
            $table->integer('COMPRA');
            $table->integer('PRODUCTO');
            $table->decimal('PRECIO', 10, 2);
            $table->integer('CANTIDAD');
            $table->timestamp('updated_at')->nullable()->default(null);

            // CLAVE PRIMARIA COMPUESTA
            $table->primary(['COMPRA', 'PRODUCTO']);

            $table->foreign('COMPRA')->references('id')->on('COMPRA')->onDelete('cascade');
            $table->foreign('PRODUCTO')->references('id')->on('PRODUCTO');
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DETALLE_COMPRA');
   }
};
