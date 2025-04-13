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
        Schema::create('CARRITO', function (Blueprint $table) {
            $table->id('ID');
            $table->text('DIRECCION');
            $table->boolean('ESTADO')->default(true);
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('CLIENTE');
            $table->string('METODO_PAGO');

            $table->foreign('CLIENTE')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('METODO_PAGO')->references('METODO_PAGO')->on('METODO_PAGO')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CARRITO');
    }
};
