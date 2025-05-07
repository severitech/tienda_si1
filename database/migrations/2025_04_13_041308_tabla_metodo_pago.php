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
        Schema::create('METODO_PAGO', function (Blueprint $table) {
            $table->string('METODO_PAGO', 50)->primary();
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            
            
            $table->timestamps();
        });
        DB::table('METODO_PAGO')->insert([
            ['METODO_PAGO' => 'QR'],
            ['METODO_PAGO' => 'Tarjeta'],
            ['METODO_PAGO' => 'Efectivo'],
            ['METODO_PAGO' => 'Transferencia Bancaria'],
            ['METODO_PAGO' => 'Stripe'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('METODO_PAGO');
    }
};
