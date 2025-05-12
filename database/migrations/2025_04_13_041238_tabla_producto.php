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

            ['CODIGO' => 'FRU001', 'NOMBRE' => 'Manzana Roja 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=69c3ebf_d3aa_4b5f_a73d_485c4381816d.jpg&co=5&size=900x900', 'PRECIO' => 31.50, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU002', 'NOMBRE' => 'Guineo Oloroso 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=1bf36c8_b282_44db_aeb5_5eaa0a677373.jpg&co=5&size=900x900', 'PRECIO' => 5.20, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU003', 'NOMBRE' => 'Tomate Pera 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=9cc1708_db89_4f78_9a33_10a67212509d.jpg&co=5&size=900x900', 'PRECIO' => 80.0, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU004', 'NOMBRE' => 'Pimenton Verde 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=5d65d4f_3735_44d2_aad9_347a3f681dab.jpg&co=5&size=900x900', 'PRECIO' => 13.0, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],
            ['CODIGO' => 'FRU005', 'NOMBRE' => 'Papaya 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=7120619_e258_4b0c_81d2_a0365fa34cce.jpg&co=5&size=900x900', 'PRECIO' => 4.5, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Frutas y Verduras'],

            ['CODIGO' => 'CONG001', 'NOMBRE' => 'Papa Sofia Pre Fritas Tradiional 400 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=6e0055f_da77_4328_a113_8a5c954874b5.jpg&co=5&size=900x900', 'PRECIO' => 20.0, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG002', 'NOMBRE' => 'Six Pack Helado Vaca Fria Vasos 150 ml', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=8d7209b_4d48_426e_9413_c199b0a4107d.jpg&co=5&size=900x900', 'PRECIO' => 69, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],
            ['CODIGO' => 'CONG003', 'NOMBRE' => 'Acai con Granola Polpanorte Banana 1020 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=f0b7a7f_0939_46ea_ae10_e2e29d4a8046.jpg&co=5&size=900x900', 'PRECIO' => 90.9, 'CANTIDAD' => 70, 'ESTADO' => true, 'CATEGORIA' => 'Congelados'],

            ['CODIGO' => 'BEB001', 'NOMBRE' => 'Agua Vital Sin Gas X 600Ml', 'IMAGEN' => 'https://farmacorp.com/cdn/shop/files/909705_599x599.jpg?v=1714434898', 'PRECIO' => 0.80, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
            ['CODIGO' => 'BEB002', 'NOMBRE' => 'Cerveza Paceña Pilsener Lata 269 ml', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=60bad7e_6ffb_4080_90d8_b80bd849550b.jpg&co=5&size=900x900', 'PRECIO' => 6.50, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],
            ['CODIGO' => 'BEB003', 'NOMBRE' => 'Cerveza Corona Botella 330 ml', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=faf1e42_3900_44e4_8043_48b5c0a26c77.jpg&co=5&size=900x900', 'PRECIO' => 11.50, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Bebidas'],

            ['CODIGO' => 'PAN001', 'NOMBRE' => 'Empanada de Queso Fritas kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=9c91e0e_8b7d_4012_a32d_61e83336c091.jpg&co=5&size=900x900', 'PRECIO' => 40.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            ['CODIGO' => 'PAN002', 'NOMBRE' => 'Pan Molde Integral Bauducco 400 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=6a42e0a_b859_4037_836d_3b21fba704e5.jpg&co=5&size=900x900', 'PRECIO' => 20.5, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            ['CODIGO' => 'PAN003', 'NOMBRE' => 'Cuñape Abizcochado Pan Hogar', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=3434cfc_17ab_4490_9866_0e6354c341e2.png&co=5&size=900x900', 'PRECIO' => 10.20, 'CANTIDAD' => 80, 'ESTADO' => true, 'CATEGORIA' => 'Panadería'],
            
            ['CODIGO' => 'SNA001', 'NOMBRE' => 'Takis Fuego Mex 240 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=ac33ea1_4b4e_43da_851e_4e753898e7b6.jpg&co=5&size=900x900', 'PRECIO' => 31.50, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            ['CODIGO' => 'SNA002', 'NOMBRE' => 'Pipoca ACT II Mantequilla Extra 91 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=a668226_a3c7_4d42_b478_cc6162ed6702.jpg&co=5&size=900x900', 'PRECIO' => 18.00, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            ['CODIGO' => 'SNA003', 'NOMBRE' => 'Pipoca Johns Pop Caramelo 200 gr', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=c95bbeb_bb48_4114_845b_1cd2ef7d5c08.jpg&co=5&size=900x900', 'PRECIO' => 19.20, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Snacks'],
            
            ['CODIGO' => 'ORG001', 'NOMBRE' => 'Lechuga La Fuente Manteca 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=85b730f_6484_4c4b_9207_f2d8baf29d16.jpg&co=5&size=900x900', 'PRECIO' => 18.70, 'CANTIDAD' => 60, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            ['CODIGO' => 'ORG002', 'NOMBRE' => 'Cebolla Blanca 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=3068cbb_51bc_45c0_a17f_79a339b72c51.jpg&co=5&size=900x900', 'PRECIO' => 14.0, 'CANTIDAD' => 50, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            ['CODIGO' => 'ORG003', 'NOMBRE' => 'Papa Holandesa 1 kg', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=a60c288_7adb_486f_8f50_8b6becc3ea94.jpg&co=5&size=900x900', 'PRECIO' => 10.5, 'CANTIDAD' => 30, 'ESTADO' => true, 'CATEGORIA' => 'Productos Orgánicos'],
            
            ['CODIGO' => 'CUID001', 'NOMBRE' => 'Papel Higienico Scott Cuidado Completo 12 un', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=8d55f4e_f6ad_4826_b08a_ba152dbe1e16.jpg&co=5&size=900x900', 'PRECIO' => 26.50, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            ['CODIGO' => 'CUID002', 'NOMBRE' => 'Desodorante Aerosol Invisible Men 150 ml', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=04178d2_b8f0_42fc_be0f_c09d625637b3.jpg&co=5&size=900x900', 'PRECIO' => 33.00, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            ['CODIGO' => 'CUID003', 'NOMBRE' => 'Maquina de Afeitar Gillette Prestobarba 3 Desechable 2 un', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=d4d2a27_9248_49cf_aa01_b60c703942bb.jpg&co=5&size=900x900', 'PRECIO' => 36.20, 'CANTIDAD' => 100, 'ESTADO' => true, 'CATEGORIA' => 'Cuidado Personal'],
            
            ['CODIGO' => 'LIM001', 'NOMBRE' => 'DETERGENTE OMO LIMON 1800 KG', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=e928c70_5079_4cb7_9e39_aac60d842e84.jpg&co=5&size=900x900', 'PRECIO' => 53.00, 'CANTIDAD' => 200, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
            ['CODIGO' => 'LIM002', 'NOMBRE' => 'Toallas Humedas Huggies Limpieza Total 80 un', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=d178c01_7120_4411_91f5_6100f0ac3d75.jpg&co=5&size=900x900', 'PRECIO' => 78.50, 'CANTIDAD' => 150, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
            ['CODIGO' => 'LIM003', 'NOMBRE' => 'Lavandina Sapolio 4730 ml', 'IMAGEN' => 'https://hipermaxi.com/tienda-api/marketfile/ImageEcommerce?hashfile=5b195b2_0d5a_4c46_a56e_4229ae192bd0.jpg&co=5&size=900x900', 'PRECIO' => 44.00, 'CANTIDAD' => 120, 'ESTADO' => true, 'CATEGORIA' => 'Hogar y Limpieza'],
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
