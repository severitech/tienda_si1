<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('COMPRA', function (Blueprint $table) {
            $table->id('ID');
            $table->text('DESCRIPCION');
            $table->decimal('TOTAL', 10, 2);
            $table->string('METODO_PAGO');
            $table->unsignedBigInteger('USUARIO');
            $table->boolean('ESTADO')->default(true);
            $table->unsignedBigInteger('PROVEEDOR');
            $table->unsignedBigInteger('CAJA')->nullable();
            
            // RELACION CON LA TABLA METODO_PAGO, USUARIO, PROVEEDOR
            $table->foreign('CAJA')->references('ID')->on('CAJA')->onDelete('cascade')->onUpdate('cascade');

            $table->foreign('METODO_PAGO')->references('METODO_PAGO')->on('METODO_PAGO')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('USUARIO')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('PROVEEDOR')->references('ID')->on('PROVEEDOR')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('COMPRA');
    }
};
