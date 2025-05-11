<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('CAJA_PAGO', function (Blueprint $table) {
            $table->integer('CAJA');
            $table->string('METODO_PAGO');
            $table->decimal('MONTO', 10, 2);
            
            // Columna para updated_at (solo actualizado, sin created_at)
            $table->timestamp('updated_at')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            // Definir la clave primaria compuesta
            $table->primary(['CAJA', 'METODO_PAGO']);

            // Relaciones con la tabla CAJA y METODO_PAGO
            $table->foreign('CAJA')->references('ID')->on('CAJA')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('METODO_PAGO')->references('METODO_PAGO')->on('METODO_PAGO')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CAJA_PAGO');
    }
};
