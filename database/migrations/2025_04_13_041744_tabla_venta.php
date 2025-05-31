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
        Schema::create('VENTA', function (Blueprint $table) {
            $table->id();
            $table->decimal('TOTAL', 10, 2);
            $table->unsignedBigInteger('USUARIO');
            $table->unsignedBigInteger('CLIENTE');
            $table->boolean('ESTADO')->default(1);
            $table->string('METODO_PAGO');
            $table->unsignedBigInteger('CAJA')->nullable();;


            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('USUARIO')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CLIENTE')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('METODO_PAGO')->references('METODO_PAGO')->on('METODO_PAGO')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('CAJA')->references('ID')->on('CAJA')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('VENTA');
   
    }
};
