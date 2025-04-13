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
        Schema::create('DETALLE_VENTA', function (Blueprint $table) {
            $table->integer('VENTA');
            $table->integer('PRODUCTO');
            $table->decimal('PRECIO', 10, 2);
            $table->integer('CANTIDAD');
            $table->timestamp('updated_at')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            //LLAVES PRIMARIAS FORANEAS
            $table->primary(['VENTA', 'PRODUCTO']);


            $table->foreign('VENTA')->references('NRO')->on('VENTA')->onDelete('cascade')->onUpdate('cascade'); 
            $table->foreign('PRODUCTO')->references('id')->on('PRODUCTO')->onDelete('cascade')->onUpdate('cascade'); 
            
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
