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
        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->id('ID');  // AUT_INCREMENT ID
            $table->string('CODIGO', 50)->unique();
            $table->string('NOMBRE', 100);
            $table->string('IMAGEN', 255)->nullable;
            $table->decimal('PRECIO', 10, 2);
            $table->integer('CANTIDAD');
            $table->boolean('ESTADO')->default(true);
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            // relacion con la tabla categoria
            $table->unsignedBigInteger('CATEGORIA');
            $table->foreign('CATEGORIA')->references('CATEGORIA')->on('CATEGORIA')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();

        });

        DB::table('PRODUCTO')->insert([
            ['CODIGO' => 'LAC001', 'NOMBRE' => 'Leche Entera', 'IMAGEN' => 'imagen1.jpg', 'PRECIO' => 1.50, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC002', 'NOMBRE' => 'Yogurt Natural', 'IMAGEN' => 'imagen2.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC003', 'NOMBRE' => 'Queso Fresco', 'IMAGEN' => 'imagen3.jpg', 'PRECIO' => 3.50, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'CAR001', 'NOMBRE' => 'Pechuga de Pollo', 'IMAGEN' => 'imagen4.jpg', 'PRECIO' => 5.00, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'CAR002', 'NOMBRE' => 'Costillas de Cerdo', 'IMAGEN' => 'imagen5.jpg', 'PRECIO' => 6.00, 'CANTIDAD' => 40, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'CAR003', 'NOMBRE' => 'Filete de Res', 'IMAGEN' => 'imagen6.jpg', 'PRECIO' => 8.00, 'CANTIDAD' => 30, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'FRU001', 'NOMBRE' => 'Manzanas', 'IMAGEN' => 'imagen7.jpg', 'PRECIO' => 1.20, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU002', 'NOMBRE' => 'Plátanos', 'IMAGEN' => 'imagen8.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU003', 'NOMBRE' => 'Tomates', 'IMAGEN' => 'imagen9.jpg', 'PRECIO' => 1.50, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'CONG001', 'NOMBRE' => 'Papas Congeladas', 'IMAGEN' => 'imagen10.jpg', 'PRECIO' => 2.00, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG002', 'NOMBRE' => 'Pechugas de Pollo Congeladas', 'IMAGEN' => 'imagen11.jpg', 'PRECIO' => 5.50, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG003', 'NOMBRE' => 'Verduras Congeladas', 'IMAGEN' => 'imagen12.jpg', 'PRECIO' => 2.50, 'CANTIDAD' => 70, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'BEB001', 'NOMBRE' => 'Agua Mineral', 'IMAGEN' => 'imagen13.jpg', 'PRECIO' => 0.80, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
            ['CODIGO' => 'BEB002', 'NOMBRE' => 'Cerveza', 'IMAGEN' => 'imagen14.jpg', 'PRECIO' => 1.80, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
            ['CODIGO' => 'BEB003', 'NOMBRE' => 'Jugo de Naranja', 'IMAGEN' => 'imagen15.jpg', 'PRECIO' => 2.00, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
            ['CODIGO' => 'PAN001', 'NOMBRE' => 'Pan Blanco', 'IMAGEN' => 'imagen16.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            ['CODIGO' => 'PAN002', 'NOMBRE' => 'Pan Integral', 'IMAGEN' => 'imagen17.jpg', 'PRECIO' => 1.50, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            ['CODIGO' => 'PAN003', 'NOMBRE' => 'Pan de Hot Dog', 'IMAGEN' => 'imagen18.jpg', 'PRECIO' => 1.20, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            ['CODIGO' => 'SNA001', 'NOMBRE' => 'Chicles', 'IMAGEN' => 'imagen19.jpg', 'PRECIO' => 0.50, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            ['CODIGO' => 'SNA002', 'NOMBRE' => 'Papas Fritas', 'IMAGEN' => 'imagen20.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            ['CODIGO' => 'SNA003', 'NOMBRE' => 'Galletas', 'IMAGEN' => 'imagen21.jpg', 'PRECIO' => 1.20, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            ['CODIGO' => 'ORG001', 'NOMBRE' => 'Lechuga Orgánica', 'IMAGEN' => 'imagen22.jpg', 'PRECIO' => 2.00, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            ['CODIGO' => 'ORG002', 'NOMBRE' => 'Manzanas Orgánicas', 'IMAGEN' => 'imagen23.jpg', 'PRECIO' => 2.50, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            ['CODIGO' => 'ORG003', 'NOMBRE' => 'Tomates Orgánicos', 'IMAGEN' => 'imagen24.jpg', 'PRECIO' => 3.00, 'CANTIDAD' => 30, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            ['CODIGO' => 'CUID001', 'NOMBRE' => 'Shampoo', 'IMAGEN' => 'imagen25.jpg', 'PRECIO' => 3.50, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            ['CODIGO' => 'CUID002', 'NOMBRE' => 'Jabón en Barra', 'IMAGEN' => 'imagen26.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            ['CODIGO' => 'CUID003', 'NOMBRE' => 'Pasta Dental', 'IMAGEN' => 'imagen27.jpg', 'PRECIO' => 1.20, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            ['CODIGO' => 'LIM001', 'NOMBRE' => 'Detergente Líquido', 'IMAGEN' => 'imagen28.jpg', 'PRECIO' => 2.00, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
            ['CODIGO' => 'LIM002', 'NOMBRE' => 'Limpiador Multiusos', 'IMAGEN' => 'imagen29.jpg', 'PRECIO' => 2.50, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
            ['CODIGO' => 'LIM003', 'NOMBRE' => 'Esponjas de Cocina', 'IMAGEN' => 'imagen30.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PRODUCTO');
    }
};
