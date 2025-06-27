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
        Schema::create('CAJA', function (Blueprint $table) {
            $table->id('ID');
            $table->decimal('DECLARADO')->default(0.00);
            $table->decimal('CIERRE')->default(0.00);
            $table->decimal('DIFERENCIA')->default(0.00);
            $table->text('DESCRIPCION')->nullable();
            $table->unsignedBigInteger('USUARIO');
            $table->foreign('USUARIO')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CAJA');
    }
};
