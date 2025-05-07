<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('DETALLE_VENTA', function (Blueprint $table) {
            $table->integer('VENTA');
            $table->integer('PRODUCTO');
            $table->decimal('PRECIO', 10, 2);
            $table->integer('CANTIDAD');


            //LLAVES PRIMARIAS FORANEAS
            $table->id();


            $table->foreign('VENTA')->references('id')->on('VENTA')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('PRODUCTO')->references('ID')->on('PRODUCTO')->onDelete('cascade')->onUpdate('cascade'); 
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('DETALLE_VENTA');
  
    }
};
