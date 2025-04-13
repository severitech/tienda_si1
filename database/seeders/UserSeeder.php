<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        DB::table('CAJA')->insert([
            ['DESCRIPCION' => 'Caja cierre diario de ventas', 'USUARIO' => 1],
            ['DESCRIPCION' => 'Caja cierre diario de ventas', 'USUARIO' => 1],
            ['DESCRIPCION' => 'Caja cierre diario de ventas', 'USUARIO' => 2],
            ['DESCRIPCION' => 'Caja cierre diario de ventas', 'USUARIO' => 2],
            ['DESCRIPCION' => 'Caja cierre diario de ventas', 'USUARIO' => 3],
        ]);
        
        DB::table('CAJA_PAGO')->insert([
            ['CAJA' => 1, 'METODO_PAGO' => 'QR', 'MONTO' => 500.00],
            ['CAJA' => 1, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 2000.00],
            ['CAJA' => 1, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 1500.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'QR', 'MONTO' => 700.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 2500.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 300.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'QR', 'MONTO' => 1200.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 500.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 1500.00],
            ['CAJA' => 4, 'METODO_PAGO' => 'QR', 'MONTO' => 750.00],
            ['CAJA' => 4, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 2300.00],
            ['CAJA' => 4, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 800.00],
            ['CAJA' => 5, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 950.00],
            ['CAJA' => 5, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 1800.00],
            ['CAJA' => 5, 'METODO_PAGO' => 'QR', 'MONTO' => 1300.00],
        ]);

        DB::table('GASTOS')->insert([
            ['DESCRIPCION' => 'Pago mensual del alquiler del local', 'MONTO' => 1000.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 1],
            ['DESCRIPCION' => 'Compra de productos de supermercado para el stock', 'MONTO' => 3000.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 2],
            ['DESCRIPCION' => 'Pago de electricidad y agua del mes', 'MONTO' => 250.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 3],
            ['DESCRIPCION' => 'Mantenimiento de equipos y aire acondicionado', 'MONTO' => 500.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 4],
            ['DESCRIPCION' => 'Publicidad para promoción de productos', 'MONTO' => 1500.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 5],
            ['DESCRIPCION' => 'Pago mensual del alquiler del local', 'MONTO' => 1000.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 1],
            ['DESCRIPCION' => 'Compra de productos para el supermercado', 'MONTO' => 1500.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 2],
            ['DESCRIPCION' => 'Pago de electricidad y agua', 'MONTO' => 300.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'QR', 'USUARIO' => 3],
            ['DESCRIPCION' => 'Mantenimiento de las instalaciones', 'MONTO' => 500.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'Tarjeta', 'USUARIO' => 4],
            ['DESCRIPCION' => 'Publicidad en redes sociales', 'MONTO' => 600.00, 'CANTIDAD' => 1, 'METODO_PAGO' => 'Tarjeta', 'USUARIO' => 5],
        ]);

        DB::table('COMPRA')->insert([
            ['TOTAL' => 100.00, 'DESCRIPCION' => 'Compra de productos de oficina', 'METODO_PAGO' => 'QR', 'USUARIO' => 1, 'PROVEEDOR' => 1],
            ['TOTAL' => 200.00, 'DESCRIPCION' => 'Compra de productos de limpieza', 'METODO_PAGO' => 'Tarjeta', 'USUARIO' => 2, 'PROVEEDOR' => 2],
            ['TOTAL' => 2000.00, 'DESCRIPCION' => 'Compra de productos de supermercado', 'METODO_PAGO' => 'QR', 'USUARIO' => 1, 'PROVEEDOR' => 1],
            ['TOTAL' => 3000.00, 'DESCRIPCION' => 'Compra de artículos electrónicos', 'METODO_PAGO' => 'Tarjeta', 'USUARIO' => 2, 'PROVEEDOR' => 2],
            ['TOTAL' => 4000.00, 'DESCRIPCION' => 'Compra de insumos para la tienda', 'METODO_PAGO' => 'Efectivo', 'USUARIO' => 3, 'PROVEEDOR' => 3],
            ['TOTAL' => 5000.00, 'DESCRIPCION' => 'Compra de equipos para mantenimiento', 'METODO_PAGO' => 'QR', 'USUARIO' => 4, 'PROVEEDOR' => 4],
            ['TOTAL' => 6000.00, 'DESCRIPCION' => 'Compra de productos para promoción', 'METODO_PAGO' => 'Tarjeta', 'USUARIO' => 5, 'PROVEEDOR' => 5],
        ]);

        DB::table('DETALLE_COMPRA')->insert([
            ['COMPRA' => 1, 'PRODUCTO' => 1, 'PRECIO' => 3.50, 'CANTIDAD' => 200],
            ['COMPRA' => 2, 'PRODUCTO' => 2, 'PRECIO' => 1.80, 'CANTIDAD' => 250],
            ['COMPRA' => 3, 'PRODUCTO' => 3, 'PRECIO' => 7.00, 'CANTIDAD' => 150],
            ['COMPRA' => 4, 'PRODUCTO' => 4, 'PRECIO' => 1.20, 'CANTIDAD' => 300],
            ['COMPRA' => 5, 'PRODUCTO' => 5, 'PRECIO' => 8.00, 'CANTIDAD' => 200],
        ]);
        DB::table('VENTA')->insert([
            ['TOTAL' => 500.00, 'USUARIO' => 1, 'CLIENTE' => 5, 'METODO_PAGO' => 'QR'],
            ['TOTAL' => 1000.00, 'USUARIO' => 2, 'CLIENTE' => 4, 'METODO_PAGO' => 'Tarjeta'],
            ['TOTAL' => 1500.00, 'USUARIO' => 3, 'CLIENTE' => 3, 'METODO_PAGO' => 'Efectivo'],
            ['TOTAL' => 2000.00, 'USUARIO' => 4, 'CLIENTE' => 2, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['TOTAL' => 2500.00, 'USUARIO' => 5, 'CLIENTE' => 1, 'METODO_PAGO' => 'Paypal'],
        ]);

        DB::table('DETALLE_VENTA')->insert([
            ['VENTA' => 1, 'PRODUCTO' => 1, 'PRECIO' => 3.50, 'CANTIDAD' => 50],
            ['VENTA' => 2, 'PRODUCTO' => 2, 'PRECIO' => 1.80, 'CANTIDAD' => 100],
            ['VENTA' => 3, 'PRODUCTO' => 3, 'PRECIO' => 7.00, 'CANTIDAD' => 70],
            ['VENTA' => 4, 'PRODUCTO' => 4, 'PRECIO' => 1.20, 'CANTIDAD' => 150],
            ['VENTA' => 5, 'PRODUCTO' => 5, 'PRECIO' => 8.00, 'CANTIDAD' => 200],
        ]);

        DB::table('CARRITO')->insert([
            ['CLIENTE' => 1, 'DIRECCION' => 'Av. Siempre Viva 123, Springfield', 'ESTADO' => 'Pendiente', 'METODO_PAGO' => 'Tarjeta'],
            ['CLIENTE' => 2, 'DIRECCION' => 'Calle Falsa 456, Springfield', 'ESTADO' => 'Pendiente', 'METODO_PAGO' => 'Tarjeta'],
            ['CLIENTE' => 3, 'DIRECCION' => 'Calle Nueva 789, Springfield', 'ESTADO' => 'Pendiente', 'METODO_PAGO' => 'Tarjeta'],
            ['CLIENTE' => 4, 'DIRECCION' => 'Calle del Sol 101, Springfield', 'ESTADO' => 'Pendiente', 'METODO_PAGO' => 'Tarjeta'],
            ['CLIENTE' => 5, 'DIRECCION' => 'Av. Libertad 202, Springfield', 'ESTADO' => 'Pendiente', 'METODO_PAGO' => 'Tarjeta'],
        ]);
        DB::table('DETALLE_CARRITO')->insert([
            ['CARRITO' => 1, 'PRODUCTO' => 1, 'PRECIO' => 3.50, 'CANTIDAD' => 5],
            ['CARRITO' => 2, 'PRODUCTO' => 2, 'PRECIO' => 1.80, 'CANTIDAD' => 10],
            ['CARRITO' => 3, 'PRODUCTO' => 3, 'PRECIO' => 7.00, 'CANTIDAD' => 7],
            ['CARRITO' => 4, 'PRODUCTO' => 4, 'PRECIO' => 1.20, 'CANTIDAD' => 15],
            ['CARRITO' => 5, 'PRODUCTO' => 5, 'PRECIO' => 8.00, 'CANTIDAD' => 20],
        ]);
    }
}
