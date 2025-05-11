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
        Schema::create('PROVEEDOR', function (Blueprint $table) {
            $table->id('ID');
            $table->string('NOMBRE', 100);
            $table->string('TELEFONO', 50);
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            $table->timestamps();
        });
        DB::table('PROVEEDOR')->insert([
            ['NOMBRE' => 'Supermercados El Buen Precio', 'TELEFONO' => '5551001'],
            ['NOMBRE' => 'Distribuidora Alimentaria S.A.', 'TELEFONO' => '5551002'],
            ['NOMBRE' => 'Fábrica de Panes La Delicia', 'TELEFONO' => '5551003'],
            ['NOMBRE' => 'Electrodomésticos García', 'TELEFONO' => '5551004'],
            ['NOMBRE' => 'Comercializadora de Bebidas Premium', 'TELEFONO' => '5551005'],
            ['NOMBRE' => 'Alimentos Naturales Orgánicos', 'TELEFONO' => '5551006'],
            ['NOMBRE' => 'Productos de Limpieza Ecológicos', 'TELEFONO' => '5551007'],
            ['NOMBRE' => 'Tecnología y Más S.A.', 'TELEFONO' => '5551008'],
            ['NOMBRE' => 'Distribuciones de Frutas y Verduras', 'TELEFONO' => '5551009'],
            ['NOMBRE' => 'Mueblería y Decoración Casa Bella', 'TELEFONO' => '5551010'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PROVEEDOR');

    }
};
