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
        Schema::create('CATEGORIA', function (Blueprint $table) {
            $table->string('CATEGORIA', 100)->primary();// clave primaria varchar
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
        DB::table('CATEGORIA')->insert([
            ['CATEGORIA' => 'Lácteos'],
            ['CATEGORIA' => 'Carnes'],
            ['CATEGORIA' => 'Frutas y Verduras'],
            ['CATEGORIA' => 'Congelados'],
            ['CATEGORIA' => 'Bebidas'],
            ['CATEGORIA' => 'Panadería'],
            ['CATEGORIA' => 'Snacks'],
            ['CATEGORIA' => 'Productos Orgánicos'],
            ['CATEGORIA' => 'Cuidado Personal'],
            ['CATEGORIA' => 'Hogar y Limpieza'],
        ]);
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('CATEGORIA');

    }
};
