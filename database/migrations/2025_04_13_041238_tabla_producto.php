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
        Schema::create('PRODUCTO', function (Blueprint $table) {
            $table->id('ID');  // AUT_INCREMENT ID
            $table->string('CODIGO', 50)->unique();
            $table->string('NOMBRE', 100);
            $table->string('IMAGEN', 255)->nullable();
            $table->decimal('PRECIO', 10, 2);
            $table->integer('CANTIDAD');
            $table->boolean('ESTADO')->default(true);
            // $table->timestamp('FECHA_CREACION')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamp('FECHA_ACTUALIZACION')->nullable()->default(null)->onUpdate(DB::raw('CURRENT_TIMESTAMP'));

            // relacion con la tabla categoria
            $table->string('CATEGORIA', 100);
            $table->foreign('CATEGORIA')->references('CATEGORIA')->on('CATEGORIA')->onDelete('cascade')->onUpdate('cascade');

            $table->timestamps();

        });

        DB::table('PRODUCTO')->insert([
            ['CODIGO' => 'LAC001', 'NOMBRE' => 'Leche Pil Natural Uht Ultra Pasteurizada X 900Ml', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/7771259757566_599x599.jpg?v=1737734597', 'PRECIO' => 7.70, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC002', 'NOMBRE' => 'Pil Yogurt Bebible Sabor A Frutilla X 1 L', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/7772905002306_599x599.jpg?v=1714441318', 'PRECIO' => 13.00, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC003', 'NOMBRE' => 'Queso Sandwichero Guaruja X 200G', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/7771908330393_599x599.jpg?v=1742313699', 'PRECIO' => 17.5, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC004', 'NOMBRE' => 'Pil Yogurt Sabor Coco X 1Lt', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/7771259754077_599x599.jpg?v=1714440853', 'PRECIO' => 18.10, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],
            ['CODIGO' => 'LAC005', 'NOMBRE' => 'Pil Yogurt Sabor A Mora Botella X 1 L', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/7772905003181_599x599.jpg?v=1714441323', 'PRECIO' => 18.10, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Lácteos'],

            ['CODIGO' => 'CAR001', 'NOMBRE' => 'Filete de Pechuga Sofia 1 kg Bandeja', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=96f6c89_5a58_4ac5_8911_61f38ea87105.jpg&co=5&size=900x900', 'PRECIO' => 49.90, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'CAR002', 'NOMBRE' => 'Pechuga con Hueso Sofia 1 kg Bandeja', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=b24174f_0c20_4b7a_8f31_2763f56c4ca5.jpg&co=5&size=900x900', 'PRECIO' => 35.00, 'CANTIDAD' => 40, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'CAR003', 'NOMBRE' => 'Pierna Sofia Bandeja 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=f838620_bc84_423b_8596_f795df04bb7d.jpg&co=5&size=900x900', 'PRECIO' => 33.50, 'CANTIDAD' => 30, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],
            ['CODIGO' => 'CAR004', 'NOMBRE' => 'Punta de S Fridosa al Vacio 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=f05a5d6_a46f_4389_9c55_0a6400483468.png&co=5&size=900x900', 'PRECIO' => 148.00, 'CANTIDAD' => 30, 'ESTADO' => true, 'CATEGORIA' => 'Carnes'],

            ['CODIGO' => 'FRU001', 'NOMBRE' => 'Manzanas', 'IMAGEN' => 'imagen7.jpg', 'PRECIO' => 1.20, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU002', 'NOMBRE' => 'Plátanos', 'IMAGEN' => 'imagen8.jpg', 'PRECIO' => 1.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU003', 'NOMBRE' => 'Tomates', 'IMAGEN' => 'imagen9.jpg', 'PRECIO' => 1.50, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'CONG001', 'NOMBRE' => 'Papas Congeladas', 'IMAGEN' => 'imagen10.jpg', 'PRECIO' => 2.00, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG002', 'NOMBRE' => 'Pechugas de Pollo Congeladas', 'IMAGEN' => 'imagen11.jpg', 'PRECIO' => 5.50, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG003', 'NOMBRE' => 'Verduras Congeladas', 'IMAGEN' => 'imagen12.jpg', 'PRECIO' => 2.50, 'CANTIDAD' => 70, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'BEB001', 'NOMBRE' => 'Agua Vital Sin Gas X 600Ml', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/909705_599x599.jpg?v=1714434898', 'PRECIO' => 0.80, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
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
