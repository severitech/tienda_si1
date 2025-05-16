<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Hash; // Importa la clase Hash
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['nombre' => 'Isael', 'paterno' => 'Ortiz', 'materno' => 'Flores', 'email' => 'isaelortiz74@gmail.com'],
            ['nombre' => 'David', 'paterno' => 'Sequeiros', 'materno' => 'Cruz', 'email' => 'sequeiros.dc44@gmail.com'],
            ['nombre' => 'Jhon', 'paterno' => 'Salas', 'materno' => 'Rodas', 'email' => 'jhonsalas68@gmail.com'],
            ['nombre' => 'Alex', 'paterno' => 'Man', 'materno' => 'Alsta', 'email' => 'alex.lx.man.alstaraciend@gmail.com'],
            ['nombre' => 'Douglas', 'paterno' => 'Padilla', 'materno' => 'Severiche', 'email' => 'padilladouglas6@gmail.com'],
            ['nombre' => 'María', 'paterno' => 'Torrez', 'materno' => 'Vargas', 'email' => 'admin6@correo.com'],
            ['nombre' => 'Laura', 'paterno' => 'Pérez', 'materno' => 'Gómez', 'email' => 'laura.perez@gmail.com'],
            ['nombre' => 'Carlos', 'paterno' => 'Ramírez', 'materno' => 'Sánchez', 'email' => 'carlos.ramirez@hotmail.com'],
            ['nombre' => 'Ana', 'paterno' => 'Martínez', 'materno' => 'González', 'email' => 'ana.martinez@yahoo.com'],
            ['nombre' => 'Luis', 'paterno' => 'Vázquez', 'materno' => 'Morales', 'email' => 'luis.vazquez@outlook.com'],
            ['nombre' => 'Patricia', 'paterno' => 'Hernández', 'materno' => 'Jiménez', 'email' => 'patricia.hernandez@live.com'],
            ['nombre' => 'Miguel', 'paterno' => 'Castillo', 'materno' => 'Ríos', 'email' => 'miguel.castillo@correo.com'],
            ['nombre' => 'Elena', 'paterno' => 'Suárez', 'materno' => 'Fernández', 'email' => 'elena.suarez@gmail.com'],
            ['nombre' => 'Javier', 'paterno' => 'López', 'materno' => 'Vega', 'email' => 'javier.lopez@gmail.com'],
            ['nombre' => 'Cristina', 'paterno' => 'Díaz', 'materno' => 'López', 'email' => 'cristina.diaz@hotmail.com'],
            ['nombre' => 'Fernando', 'paterno' => 'González', 'materno' => 'Hernández', 'email' => 'fernando.gonzalez@icloud.com'],
            
        ];

        foreach ($admins as $admin) {
            User::create([
                'nombre' => $admin['nombre'],
                'paterno' => $admin['paterno'],
                'materno' => $admin['materno'],
                'telefono' => '70000000',
                'email' => $admin['email'],
                'password' => Hash::make('12346578'), // Asegúrate de cambiar la contraseña por algo más seguro
                'ROL' => 'cliente',
            ]);
        }
        DB::table('VENTA')->insert([
            ['TOTAL' => 150.75, 'USUARIO' => 1, 'CLIENTE' => 3, 'ESTADO' => 1, 'METODO_PAGO' => 'QR'],
            ['TOTAL' => 230.50, 'USUARIO' => 2, 'CLIENTE' => 4, 'ESTADO' => 1, 'METODO_PAGO' => 'Tarjeta'],
            ['TOTAL' => 120.00, 'USUARIO' => 3, 'CLIENTE' => 5, 'ESTADO' => 1, 'METODO_PAGO' => 'Efectivo'],
            ['TOTAL' => 450.20, 'USUARIO' => 4, 'CLIENTE' => 6, 'ESTADO' => 1, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['TOTAL' => 75.99, 'USUARIO' => 5, 'CLIENTE' => 7, 'ESTADO' => 1, 'METODO_PAGO' => 'Stripe'],
            ['TOTAL' => 200.30, 'USUARIO' => 6, 'CLIENTE' => 8, 'ESTADO' => 1, 'METODO_PAGO' => 'QR'],
            ['TOTAL' => 99.99, 'USUARIO' => 7, 'CLIENTE' => 9, 'ESTADO' => 1, 'METODO_PAGO' => 'Tarjeta'],
            ['TOTAL' => 380.45, 'USUARIO' => 8, 'CLIENTE' => 10, 'ESTADO' => 1, 'METODO_PAGO' => 'Efectivo'],
            ['TOTAL' => 510.00, 'USUARIO' => 9, 'CLIENTE' => 11, 'ESTADO' => 1, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['TOTAL' => 1500.75, 'USUARIO' => 10, 'CLIENTE' => 12, 'ESTADO' => 1, 'METODO_PAGO' => 'Stripe'],
            ['TOTAL' => 95.99, 'USUARIO' => 11, 'CLIENTE' => 13, 'ESTADO' => 1, 'METODO_PAGO' => 'QR'],
            ['TOTAL' => 870.50, 'USUARIO' => 12, 'CLIENTE' => 14, 'ESTADO' => 1, 'METODO_PAGO' => 'Tarjeta'],
            ['TOTAL' => 135.60, 'USUARIO' => 13, 'CLIENTE' => 15, 'ESTADO' => 1, 'METODO_PAGO' => 'Efectivo'],
            ['TOTAL' => 220.00, 'USUARIO' => 14, 'CLIENTE' => 16, 'ESTADO' => 1, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['TOTAL' => 310.80, 'USUARIO' => 15, 'CLIENTE' => 13, 'ESTADO' => 1, 'METODO_PAGO' => 'Stripe'],
        ]);
        DB::table('DETALLE_VENTA')->insert([
            // Venta 1: 2 productos
            ['VENTA' => 1, 'PRODUCTO' => 1, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
            ['VENTA' => 1, 'PRODUCTO' => 2, 'PRECIO' => 30.00, 'CANTIDAD' => 1],
        
            // Venta 2: 3 productos
            ['VENTA' => 2, 'PRODUCTO' => 3, 'PRECIO' => 25.00, 'CANTIDAD' => 1],
            ['VENTA' => 2, 'PRODUCTO' => 4, 'PRECIO' => 15.50, 'CANTIDAD' => 2],
            ['VENTA' => 2, 'PRODUCTO' => 5, 'PRECIO' => 12.00, 'CANTIDAD' => 1],
        
            // Venta 3: 4 productos
            ['VENTA' => 3, 'PRODUCTO' => 6, 'PRECIO' => 45.00, 'CANTIDAD' => 3],
            ['VENTA' => 3, 'PRODUCTO' => 7, 'PRECIO' => 20.00, 'CANTIDAD' => 1],
            ['VENTA' => 3, 'PRODUCTO' => 8, 'PRECIO' => 75.00, 'CANTIDAD' => 2],
            ['VENTA' => 3, 'PRODUCTO' => 9, 'PRECIO' => 55.00, 'CANTIDAD' => 1],
        
            // Venta 4: 2 productos
            ['VENTA' => 4, 'PRODUCTO' => 10, 'PRECIO' => 30.00, 'CANTIDAD' => 3],
            ['VENTA' => 4, 'PRODUCTO' => 11, 'PRECIO' => 80.00, 'CANTIDAD' => 1],
        
            // Venta 5: 3 productos
            ['VENTA' => 5, 'PRODUCTO' => 12, 'PRECIO' => 60.00, 'CANTIDAD' => 2],
            ['VENTA' => 5, 'PRODUCTO' => 13, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
            ['VENTA' => 5, 'PRODUCTO' => 14, 'PRECIO' => 22.00, 'CANTIDAD' => 2],
            ['VENTA' => 6, 'PRODUCTO' => 15, 'PRECIO' => 18.00, 'CANTIDAD' => 1],
            ['VENTA' => 6, 'PRODUCTO' => 16, 'PRECIO' => 25.50, 'CANTIDAD' => 3],
    
            // Venta 7: 3 productos
            ['VENTA' => 7, 'PRODUCTO' => 17, 'PRECIO' => 34.00, 'CANTIDAD' => 2],
        ['VENTA' => 7, 'PRODUCTO' => 18, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
        ['VENTA' => 7, 'PRODUCTO' => 19, 'PRECIO' => 22.00, 'CANTIDAD' => 4],
    
        // Venta 8: 4 productos
        ['VENTA' => 8, 'PRODUCTO' => 20, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
        ['VENTA' => 8, 'PRODUCTO' => 21, 'PRECIO' => 15.00, 'CANTIDAD' => 3],
        ['VENTA' => 8, 'PRODUCTO' => 22, 'PRECIO' => 60.00, 'CANTIDAD' => 1],
        ['VENTA' => 8, 'PRODUCTO' => 23, 'PRECIO' => 5.50, 'CANTIDAD' => 10],
    
        // Venta 9: 3 productos
        ['VENTA' => 9, 'PRODUCTO' => 24, 'PRECIO' => 45.00, 'CANTIDAD' => 2],
        ['VENTA' => 9, 'PRODUCTO' => 25, 'PRECIO' => 30.00, 'CANTIDAD' => 1],
        ['VENTA' => 9, 'PRODUCTO' => 26, 'PRECIO' => 19.00, 'CANTIDAD' => 5],
    
        // Venta 10: 2 productos
        ['VENTA' => 10, 'PRODUCTO' => 27, 'PRECIO' => 80.00, 'CANTIDAD' => 1],
        ['VENTA' => 10, 'PRODUCTO' => 28, 'PRECIO' => 45.50, 'CANTIDAD' => 3],
    
        // Venta 11: 3 productos
        ['VENTA' => 11, 'PRODUCTO' => 29, 'PRECIO' => 15.00, 'CANTIDAD' => 5],
        ['VENTA' => 11, 'PRODUCTO' => 30, 'PRECIO' => 22.50, 'CANTIDAD' => 2],
        ['VENTA' => 11, 'PRODUCTO' => 31, 'PRECIO' => 10.00, 'CANTIDAD' => 3],
    
        // Venta 12: 4 productos
        ['VENTA' => 12, 'PRODUCTO' => 32, 'PRECIO' => 32.50, 'CANTIDAD' => 2],
        ['VENTA' => 12, 'PRODUCTO' => 33, 'PRECIO' => 70.00, 'CANTIDAD' => 1],
        ['VENTA' => 12, 'PRODUCTO' => 34, 'PRECIO' => 25.00, 'CANTIDAD' => 4],
        ['VENTA' => 12, 'PRODUCTO' => 35, 'PRECIO' => 15.00, 'CANTIDAD' => 6],
    
        // Venta 13: 2 productos
        ['VENTA' => 13, 'PRODUCTO' => 34, 'PRECIO' => 90.00, 'CANTIDAD' => 1],
        ['VENTA' => 13, 'PRODUCTO' => 33, 'PRECIO' => 40.00, 'CANTIDAD' => 2],
    
        // Venta 14: 3 productos
        ['VENTA' => 14, 'PRODUCTO' => 32, 'PRECIO' => 28.00, 'CANTIDAD' => 2],
        ['VENTA' => 14, 'PRODUCTO' => 31, 'PRECIO' => 18.50, 'CANTIDAD' => 4],
        ['VENTA' => 14, 'PRODUCTO' => 30, 'PRECIO' => 35.00, 'CANTIDAD' => 1],
    
        // Venta 15: 4 productos
        ['VENTA' => 15, 'PRODUCTO' => 31, 'PRECIO' => 25.00, 'CANTIDAD' => 3],
        ['VENTA' => 15, 'PRODUCTO' => 32, 'PRECIO' => 10.50, 'CANTIDAD' => 5],
        ['VENTA' => 15, 'PRODUCTO' => 33, 'PRECIO' => 45.00, 'CANTIDAD' => 2],
        ['VENTA' => 15, 'PRODUCTO' => 34, 'PRECIO' => 60.00, 'CANTIDAD' => 1],
        ]);
        
        DB::table('CARRITO')->insert([
            // Carrito 1
            [
                'TOTAL' => 120.50,
                'DIRECCION' => 'Av. Siempre Viva 742, Springfield, USA',
                'ESTADO' => true,
                'CLIENTE' => 1, // ID de cliente 1
                'METODO_PAGO' => 'Stripe', // Método de pago 'Tarjeta'
            ],
            // Carrito 2
            [
                'TOTAL' => 200.00,
                'DIRECCION' => 'Calle Falsa 123, Ciudad, México',
                'ESTADO' => true,
                'CLIENTE' => 2, // ID de cliente 2
                'METODO_PAGO' => 'Stripe', // Método de pago 'Efectivo'
            ],
            // Carrito 3
            [
                'TOTAL' => 350.75,
                'DIRECCION' => 'Calle del Sol 456, Buenos Aires, Argentina',
                'ESTADO' => false, // Carrito en estado "no activo"
                'CLIENTE' => 3, // ID de cliente 3
                'METODO_PAGO' => 'Stripe', // Método de pago 'QR'
            ],
            // Carrito 4
            [
                'TOTAL' => 450.00,
                'DIRECCION' => 'Plaza Mayor 789, Madrid, España',
                'ESTADO' => true,
                'CLIENTE' => 4, // ID de cliente 4
                'METODO_PAGO' => 'Stripe', // Método de pago 'Transferencia Bancaria'
            ],
            // Carrito 5
            [
                'TOTAL' => 80.25,
                'DIRECCION' => 'Avenida 9 de Julio 101, Buenos Aires, Argentina',
                'ESTADO' => true,
                'CLIENTE' => 5, // ID de cliente 5
                'METODO_PAGO' => 'Stripe', // Método de pago 'Stripe'
            ],
            // Carrito 6
        [
            'TOTAL' => 310.00,
            'DIRECCION' => 'Calle Luna 112, Lima, Perú',
            'ESTADO' => true,
            'CLIENTE' => 6,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 7
        [
            'TOTAL' => 99.99,
            'DIRECCION' => 'Av. Reforma 345, Ciudad de México, México',
            'ESTADO' => false,
            'CLIENTE' => 7,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 8
        [
            'TOTAL' => 500.25,
            'DIRECCION' => 'Rua das Flores 567, São Paulo, Brasil',
            'ESTADO' => true,
            'CLIENTE' => 8,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 9
        [
            'TOTAL' => 275.60,
            'DIRECCION' => 'Av. Bolívar 789, Caracas, Venezuela',
            'ESTADO' => true,
            'CLIENTE' => 9,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 10
        [
            'TOTAL' => 145.45,
            'DIRECCION' => 'Av. del Libertador 321, Buenos Aires, Argentina',
            'ESTADO' => false,
            'CLIENTE' => 10,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 11
        [
            'TOTAL' => 210.10,
            'DIRECCION' => 'Calle Mayor 121, Madrid, España',
            'ESTADO' => true,
            'CLIENTE' => 11,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 12
        [
            'TOTAL' => 88.88,
            'DIRECCION' => 'Boulevard de los Sueños 45, Guadalajara, México',
            'ESTADO' => true,
            'CLIENTE' => 12,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 13
        [
            'TOTAL' => 390.00,
            'DIRECCION' => 'Carrera 10 No. 20-30, Bogotá, Colombia',
            'ESTADO' => false,
            'CLIENTE' => 13,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 14
        [
            'TOTAL' => 60.00,
            'DIRECCION' => 'Av. Insurgentes 900, Ciudad de México, México',
            'ESTADO' => true,
            'CLIENTE' => 14,
            'METODO_PAGO' => 'Stripe',
        ],
        // Carrito 15
        [
            'TOTAL' => 120.75,
            'DIRECCION' => 'Calle Real 56, Cusco, Perú',
            'ESTADO' => true,
            'CLIENTE' => 15,
            'METODO_PAGO' => 'Stripe',
        ],
        ]);
        DB::table('DETALLE_CARRITO')->insert([
            // Detalle Carrito 1
            ['CARRITO' => 1, 'PRODUCTO' => 1, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
            ['CARRITO' => 1, 'PRODUCTO' => 2, 'PRECIO' => 25.50, 'CANTIDAD' => 1],
        
            // Detalle Carrito 2
            ['CARRITO' => 2, 'PRODUCTO' => 3, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
            ['CARRITO' => 2, 'PRODUCTO' => 4, 'PRECIO' => 15.00, 'CANTIDAD' => 2],
            ['CARRITO' => 2, 'PRODUCTO' => 5, 'PRECIO' => 30.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 3
            ['CARRITO' => 3, 'PRODUCTO' => 6, 'PRECIO' => 10.00, 'CANTIDAD' => 3],
            ['CARRITO' => 3, 'PRODUCTO' => 7, 'PRECIO' => 20.00, 'CANTIDAD' => 2],
        
            // Detalle Carrito 4
            ['CARRITO' => 4, 'PRODUCTO' => 8, 'PRECIO' => 70.00, 'CANTIDAD' => 1],
            ['CARRITO' => 4, 'PRODUCTO' => 9, 'PRECIO' => 50.00, 'CANTIDAD' => 1],
            ['CARRITO' => 4, 'PRODUCTO' => 10, 'PRECIO' => 15.00, 'CANTIDAD' => 3],
        
            // Detalle Carrito 5
            ['CARRITO' => 5, 'PRODUCTO' => 11, 'PRECIO' => 40.00, 'CANTIDAD' => 2],
            ['CARRITO' => 5, 'PRODUCTO' => 12, 'PRECIO' => 20.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 6
            ['CARRITO' => 6, 'PRODUCTO' => 13, 'PRECIO' => 25.00, 'CANTIDAD' => 1],
            ['CARRITO' => 6, 'PRODUCTO' => 14, 'PRECIO' => 35.00, 'CANTIDAD' => 2],
            ['CARRITO' => 6, 'PRODUCTO' => 15, 'PRECIO' => 45.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 7
            ['CARRITO' => 7, 'PRODUCTO' => 16, 'PRECIO' => 30.00, 'CANTIDAD' => 1],
            ['CARRITO' => 7, 'PRODUCTO' => 17, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 8
            ['CARRITO' => 8, 'PRODUCTO' => 18, 'PRECIO' => 60.00, 'CANTIDAD' => 1],
            ['CARRITO' => 8, 'PRODUCTO' => 19, 'PRECIO' => 20.00, 'CANTIDAD' => 3],
            ['CARRITO' => 8, 'PRODUCTO' => 20, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
        
            // Detalle Carrito 9
            ['CARRITO' => 9, 'PRODUCTO' => 21, 'PRECIO' => 25.50, 'CANTIDAD' => 2],
            ['CARRITO' => 9, 'PRODUCTO' => 22, 'PRECIO' => 35.00, 'CANTIDAD' => 1],
            ['CARRITO' => 9, 'PRODUCTO' => 23, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 10
            ['CARRITO' => 10, 'PRODUCTO' => 24, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
            ['CARRITO' => 10, 'PRODUCTO' => 25, 'PRECIO' => 25.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 11
            ['CARRITO' => 11, 'PRODUCTO' => 26, 'PRECIO' => 75.00, 'CANTIDAD' => 1],
            ['CARRITO' => 11, 'PRODUCTO' => 27, 'PRECIO' => 30.00, 'CANTIDAD' => 2],
        
            // Detalle Carrito 12
            ['CARRITO' => 12, 'PRODUCTO' => 28, 'PRECIO' => 50.00, 'CANTIDAD' => 1],
            ['CARRITO' => 12, 'PRODUCTO' => 29, 'PRECIO' => 20.00, 'CANTIDAD' => 2],
        
            // Detalle Carrito 13
            ['CARRITO' => 13, 'PRODUCTO' => 30, 'PRECIO' => 60.00, 'CANTIDAD' => 1],
            ['CARRITO' => 13, 'PRODUCTO' => 31, 'PRECIO' => 35.00, 'CANTIDAD' => 1],
            ['CARRITO' => 13, 'PRODUCTO' => 32, 'PRECIO' => 40.00, 'CANTIDAD' => 2],
        
            // Detalle Carrito 14
            ['CARRITO' => 14, 'PRODUCTO' => 33, 'PRECIO' => 80.00, 'CANTIDAD' => 1],
            ['CARRITO' => 14, 'PRODUCTO' => 34, 'PRECIO' => 60.00, 'CANTIDAD' => 1],
        
            // Detalle Carrito 15
            ['CARRITO' => 15, 'PRODUCTO' => 35, 'PRECIO' => 50.00, 'CANTIDAD' => 3],
            ['CARRITO' => 15, 'PRODUCTO' => 30, 'PRECIO' => 30.00, 'CANTIDAD' => 1],
            ['CARRITO' => 15, 'PRODUCTO' => 32, 'PRECIO' => 20.00, 'CANTIDAD' => 2],
        ]);
        DB::table('COMPRA')->insert([
            // Compra 1
            [
                'DESCRIPCION' => 'Compra de equipo tecnológico para la oficina.',
                'TOTAL' => 1200.50,
                'METODO_PAGO' => 'Transferencia Bancaria',
                'USUARIO' => 1,
                'PROVEEDOR' => 2,
            ],
            // Compra 2
            [
                'DESCRIPCION' => 'Material de oficina y papelería para la empresa.',
                'TOTAL' => 350.75,
                'METODO_PAGO' => 'Efectivo',
                'USUARIO' => 2,
                'PROVEEDOR' => 3,
            ],
            // Compra 3
            [
                'DESCRIPCION' => 'Compra de computadoras y accesorios.',
                'TOTAL' => 5500.00,
                'METODO_PAGO' => 'Tarjeta',
                'USUARIO' => 3,
                'PROVEEDOR' => 1,
            ],
            // Compra 4
            [
                'DESCRIPCION' => 'Suministros de impresión para la empresa.',
                'TOTAL' => 430.60,
                'METODO_PAGO' => 'Stripe',
                'USUARIO' => 4,
                'PROVEEDOR' => 4,
            ],
            // Compra 5
            [
                'DESCRIPCION' => 'Compra de herramientas para la oficina.',
                'TOTAL' => 270.50,
                'METODO_PAGO' => 'QR',
                'USUARIO' => 5,
                'PROVEEDOR' => 5,
            ],
            // Compra 6
            [
                'DESCRIPCION' => 'Compra de software de diseño gráfico.',
                'TOTAL' => 800.00,
                'METODO_PAGO' => 'Transferencia Bancaria',
                'USUARIO' => 6,
                'PROVEEDOR' => 2,
            ],
            // Compra 7
            [
                'DESCRIPCION' => 'Servicios de mantenimiento de equipos tecnológicos.',
                'TOTAL' => 150.00,
                'METODO_PAGO' => 'Efectivo',
                'USUARIO' => 7,
                'PROVEEDOR' => 3,
            ],
            // Compra 8
            [
                'DESCRIPCION' => 'Compra de sillas y escritorios ergonómicos.',
                'TOTAL' => 1900.00,
                'METODO_PAGO' => 'Tarjeta',
                'USUARIO' => 8,
                'PROVEEDOR' => 4,
            ],
            // Compra 9
            [
                'DESCRIPCION' => 'Adquisición de equipo fotográfico para el departamento de marketing.',
                'TOTAL' => 2200.30,
                'METODO_PAGO' => 'Stripe',
                'USUARIO' => 9,
                'PROVEEDOR' => 1,
            ],
            // Compra 10
            [
                'DESCRIPCION' => 'Compra de impresoras y consumibles.',
                'TOTAL' => 800.50,
                'METODO_PAGO' => 'QR',
                'USUARIO' => 10,
                'PROVEEDOR' => 5,
            ],
        ]);
    
        DB::table('DETALLE_COMPRA')->insert([
            // Detalle Compra 1
            ['COMPRA' => 1, 'PRODUCTO' => 1, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
            ['COMPRA' => 1, 'PRODUCTO' => 2, 'PRECIO' => 30.00, 'CANTIDAD' => 3],
        
            // Detalle Compra 2
            ['COMPRA' => 2, 'PRODUCTO' => 3, 'PRECIO' => 15.50, 'CANTIDAD' => 2],
            ['COMPRA' => 2, 'PRODUCTO' => 4, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
            ['COMPRA' => 2, 'PRODUCTO' => 5, 'PRECIO' => 25.00, 'CANTIDAD' => 4],
        
            // Detalle Compra 3
            ['COMPRA' => 3, 'PRODUCTO' => 6, 'PRECIO' => 75.00, 'CANTIDAD' => 1],
            ['COMPRA' => 3, 'PRODUCTO' => 7, 'PRECIO' => 50.00, 'CANTIDAD' => 2],
        
            // Detalle Compra 4
            ['COMPRA' => 4, 'PRODUCTO' => 8, 'PRECIO' => 20.00, 'CANTIDAD' => 2],
            ['COMPRA' => 4, 'PRODUCTO' => 9, 'PRECIO' => 10.00, 'CANTIDAD' => 3],
            ['COMPRA' => 4, 'PRODUCTO' => 10, 'PRECIO' => 25.00, 'CANTIDAD' => 4],
        
            // Detalle Compra 5
            ['COMPRA' => 5, 'PRODUCTO' => 11, 'PRECIO' => 45.00, 'CANTIDAD' => 1],
            ['COMPRA' => 5, 'PRODUCTO' => 12, 'PRECIO' => 35.00, 'CANTIDAD' => 2],
        
            // Detalle Compra 6
            ['COMPRA' => 6, 'PRODUCTO' => 13, 'PRECIO' => 60.00, 'CANTIDAD' => 3],
            ['COMPRA' => 6, 'PRODUCTO' => 14, 'PRECIO' => 40.00, 'CANTIDAD' => 1],
            ['COMPRA' => 6, 'PRODUCTO' => 15, 'PRECIO' => 45.00, 'CANTIDAD' => 2],
        
            // Detalle Compra 7
            ['COMPRA' => 7, 'PRODUCTO' => 16, 'PRECIO' => 90.00, 'CANTIDAD' => 1],
            ['COMPRA' => 7, 'PRODUCTO' => 17, 'PRECIO' => 65.00, 'CANTIDAD' => 2],
        
            // Detalle Compra 8
            ['COMPRA' => 8, 'PRODUCTO' => 18, 'PRECIO' => 120.00, 'CANTIDAD' => 2],
            ['COMPRA' => 8, 'PRODUCTO' => 19, 'PRECIO' => 45.00, 'CANTIDAD' => 3],
            ['COMPRA' => 8, 'PRODUCTO' => 20, 'PRECIO' => 30.00, 'CANTIDAD' => 4],
        
            // Detalle Compra 9
            ['COMPRA' => 9, 'PRODUCTO' => 21, 'PRECIO' => 25.00, 'CANTIDAD' => 2],
            ['COMPRA' => 9, 'PRODUCTO' => 22, 'PRECIO' => 50.00, 'CANTIDAD' => 1],
            ['COMPRA' => 9, 'PRODUCTO' => 23, 'PRECIO' => 40.00, 'CANTIDAD' => 2],
        
            // Detalle Compra 10
            ['COMPRA' => 10, 'PRODUCTO' => 24, 'PRECIO' => 35.00, 'CANTIDAD' => 1],
            ['COMPRA' => 10, 'PRODUCTO' => 25, 'PRECIO' => 20.00, 'CANTIDAD' => 3],
            ['COMPRA' => 10, 'PRODUCTO' => 26, 'PRECIO' => 15.00, 'CANTIDAD' => 2],
        ]);
        DB::table('CAJA')->insert([
            // Caja 1
            [
                'ID' => 1,
                'DESCRIPCION' => 'Caja de ventas de la tienda principal.',
                'USUARIO' => 1, // Asumiendo que el usuario con ID 1 existe
            ],
            // Caja 2
            [
                'ID' => 2,
                'DESCRIPCION' => 'Caja de ventas de la sucursal A.',
                'USUARIO' => 2,
            ],
            // Caja 3
            [
                'ID' => 3,
                'DESCRIPCION' => 'Caja de ventas de la sucursal B.',
                'USUARIO' => 3,
            ],
            // Caja 4
            [
                'ID' => 4,
                'DESCRIPCION' => 'Caja de devoluciones de productos defectuosos.',
                'USUARIO' => 4,
            ],
            // Caja 5
            [
                'ID' => 5,
                'DESCRIPCION' => 'Caja de pagos de proveedores.',
                'USUARIO' => 5,
            ],
            // Caja 6
            [
                'ID' => 6,
                'DESCRIPCION' => 'Caja para pagos de clientes en efectivo.',
                'USUARIO' => 6,
            ],
            // Caja 7
            [
                'ID' => 7,
                'DESCRIPCION' => 'Caja de pagos con tarjeta.',
                'USUARIO' => 7,
            ],
            // Caja 8
            [
                'ID' => 8,
                'DESCRIPCION' => 'Caja de pagos en línea (Stripe, PayPal).',
                'USUARIO' => 8,
            ],
            // Caja 9
            [
                'ID' => 9,
                'DESCRIPCION' => 'Caja de ventas por la tienda en línea.',
                'USUARIO' => 9,
            ],
            // Caja 10
            [
                'ID' => 10,
                'DESCRIPCION' => 'Caja de pagos de compras al por mayor.',
                'USUARIO' => 10,
            ],
        ]);
            
        DB::table('CAJA_PAGO')->insert([
            // Caja 1 (No tiene Transferencia Bancaria ni Stripe)
            ['CAJA' => 1, 'METODO_PAGO' => 'QR', 'MONTO' => 120.00],
            ['CAJA' => 1, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 150.00],
            ['CAJA' => 1, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 80.00],
        
            // Caja 2 (No tiene Efectivo)
            ['CAJA' => 2, 'METODO_PAGO' => 'QR', 'MONTO' => 200.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 220.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 180.00],
            ['CAJA' => 2, 'METODO_PAGO' => 'Stripe', 'MONTO' => 210.00],
        
            // Caja 3 (Tiene todos los métodos de pago)
            ['CAJA' => 3, 'METODO_PAGO' => 'QR', 'MONTO' => 100.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 120.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 130.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 110.00],
            ['CAJA' => 3, 'METODO_PAGO' => 'Stripe', 'MONTO' => 115.00],
        
            // Caja 4 (No tiene Tarjeta ni Stripe)
            ['CAJA' => 4, 'METODO_PAGO' => 'QR', 'MONTO' => 90.00],
            ['CAJA' => 4, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 85.00],
            ['CAJA' => 4, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 95.00],
        
            // Caja 5 (No tiene QR ni Stripe)
            ['CAJA' => 5, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 150.00],
            ['CAJA' => 5, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 100.00],
            ['CAJA' => 5, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 120.00],
        
            // Caja 6 (No tiene Transferencia Bancaria ni Stripe)
            ['CAJA' => 6, 'METODO_PAGO' => 'QR', 'MONTO' => 110.00],
            ['CAJA' => 6, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 130.00],
            ['CAJA' => 6, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 125.00],
        
            // Caja 7 (Solo tiene QR y Transferencia Bancaria)
            ['CAJA' => 7, 'METODO_PAGO' => 'QR', 'MONTO' => 90.00],
            ['CAJA' => 7, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 160.00],
        
            // Caja 8 (Solo tiene Efectivo y Transferencia Bancaria)
            ['CAJA' => 8, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 75.00],
            ['CAJA' => 8, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 80.00],
        
            // Caja 9 (No tiene QR ni Tarjeta)
            ['CAJA' => 9, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 60.00],
            ['CAJA' => 9, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 95.00],
            ['CAJA' => 9, 'METODO_PAGO' => 'Stripe', 'MONTO' => 110.00],
        
            // Caja 10 (Todos los métodos con valores variados)
            ['CAJA' => 10, 'METODO_PAGO' => 'QR', 'MONTO' => 100.00],
            ['CAJA' => 10, 'METODO_PAGO' => 'Tarjeta', 'MONTO' => 140.00],
            ['CAJA' => 10, 'METODO_PAGO' => 'Efectivo', 'MONTO' => 120.00],
            ['CAJA' => 10, 'METODO_PAGO' => 'Transferencia Bancaria', 'MONTO' => 115.00],
            ['CAJA' => 10, 'METODO_PAGO' => 'Stripe', 'MONTO' => 130.00],
        ]);
        DB::table('GASTOS')->insert([
            // Usuario 1 (No tiene Transferencia Bancaria ni Stripe)
            ['DESCRIPCION' => 'Compra de suministros', 'MONTO' => 120.00, 'CANTIDAD' => 3, 'USUARIO' => 1, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Pago de servicios', 'MONTO' => 150.00, 'CANTIDAD' => 1, 'USUARIO' => 1, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Compra de equipo', 'MONTO' => 80.00, 'CANTIDAD' => 2, 'USUARIO' => 1, 'METODO_PAGO' => 'Efectivo'],
        
            // Usuario 2 (No tiene Efectivo)
            ['DESCRIPCION' => 'Pago de proveedores', 'MONTO' => 200.00, 'CANTIDAD' => 5, 'USUARIO' => 2, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Compra de licencias', 'MONTO' => 220.00, 'CANTIDAD' => 2, 'USUARIO' => 2, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Pago de servicios bancarios', 'MONTO' => 180.00, 'CANTIDAD' => 1, 'USUARIO' => 2, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['DESCRIPCION' => 'Pago online', 'MONTO' => 210.00, 'CANTIDAD' => 4, 'USUARIO' => 2, 'METODO_PAGO' => 'Stripe'],
        
            // Usuario 3 (Tiene todos los métodos de pago)
            ['DESCRIPCION' => 'Compra de material de oficina', 'MONTO' => 100.00, 'CANTIDAD' => 10, 'USUARIO' => 3, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Pago de factura eléctrica', 'MONTO' => 120.00, 'CANTIDAD' => 1, 'USUARIO' => 3, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Compra de equipos de computo', 'MONTO' => 130.00, 'CANTIDAD' => 2, 'USUARIO' => 3, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Pago de software', 'MONTO' => 110.00, 'CANTIDAD' => 3, 'USUARIO' => 3, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['DESCRIPCION' => 'Pago de suscripción mensual', 'MONTO' => 115.00, 'CANTIDAD' => 1, 'USUARIO' => 3, 'METODO_PAGO' => 'Stripe'],
        
            // Usuario 4 (No tiene Tarjeta ni Stripe)
            ['DESCRIPCION' => 'Compra de suministros de oficina', 'MONTO' => 90.00, 'CANTIDAD' => 5, 'USUARIO' => 4, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Pago de servicios de internet', 'MONTO' => 85.00, 'CANTIDAD' => 1, 'USUARIO' => 4, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Compra de material', 'MONTO' => 95.00, 'CANTIDAD' => 10, 'USUARIO' => 4, 'METODO_PAGO' => 'Transferencia Bancaria'],
        
            // Usuario 5 (No tiene QR ni Stripe)
            ['DESCRIPCION' => 'Compra de cámaras de seguridad', 'MONTO' => 150.00, 'CANTIDAD' => 2, 'USUARIO' => 5, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Pago de gastos operativos', 'MONTO' => 100.00, 'CANTIDAD' => 1, 'USUARIO' => 5, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Compra de software de contabilidad', 'MONTO' => 120.00, 'CANTIDAD' => 1, 'USUARIO' => 5, 'METODO_PAGO' => 'Transferencia Bancaria'],
        
            // Usuario 6 (No tiene Transferencia Bancaria ni Stripe)
            ['DESCRIPCION' => 'Compra de equipos para oficina', 'MONTO' => 110.00, 'CANTIDAD' => 2, 'USUARIO' => 6, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Pago de servicios de mantenimiento', 'MONTO' => 130.00, 'CANTIDAD' => 3, 'USUARIO' => 6, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Compra de muebles de oficina', 'MONTO' => 125.00, 'CANTIDAD' => 4, 'USUARIO' => 6, 'METODO_PAGO' => 'Efectivo'],
        
            // Usuario 7 (Solo tiene QR y Transferencia Bancaria)
            ['DESCRIPCION' => 'Pago de insumos de oficina', 'MONTO' => 90.00, 'CANTIDAD' => 6, 'USUARIO' => 7, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Compra de equipos electrónicos', 'MONTO' => 160.00, 'CANTIDAD' => 3, 'USUARIO' => 7, 'METODO_PAGO' => 'Transferencia Bancaria'],
        
            // Usuario 8 (Solo tiene Efectivo y Transferencia Bancaria)
            ['DESCRIPCION' => 'Compra de material de oficina', 'MONTO' => 75.00, 'CANTIDAD' => 10, 'USUARIO' => 8, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Pago de suscripción mensual', 'MONTO' => 80.00, 'CANTIDAD' => 1, 'USUARIO' => 8, 'METODO_PAGO' => 'Transferencia Bancaria'],
        
            // Usuario 9 (No tiene QR ni Tarjeta)
            ['DESCRIPCION' => 'Pago de servicios de telecomunicaciones', 'MONTO' => 60.00, 'CANTIDAD' => 1, 'USUARIO' => 9, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Compra de equipos de trabajo', 'MONTO' => 95.00, 'CANTIDAD' => 2, 'USUARIO' => 9, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['DESCRIPCION' => 'Pago de software de gestión', 'MONTO' => 110.00, 'CANTIDAD' => 1, 'USUARIO' => 9, 'METODO_PAGO' => 'Stripe'],
        
            // Usuario 10 (Todos los métodos con valores variados)
            ['DESCRIPCION' => 'Compra de equipos tecnológicos', 'MONTO' => 100.00, 'CANTIDAD' => 2, 'USUARIO' => 10, 'METODO_PAGO' => 'QR'],
            ['DESCRIPCION' => 'Pago de servicios de internet', 'MONTO' => 140.00, 'CANTIDAD' => 1, 'USUARIO' => 10, 'METODO_PAGO' => 'Tarjeta'],
            ['DESCRIPCION' => 'Pago de salario', 'MONTO' => 120.00, 'CANTIDAD' => 1, 'USUARIO' => 10, 'METODO_PAGO' => 'Efectivo'],
            ['DESCRIPCION' => 'Compra de herramientas de oficina', 'MONTO' => 115.00, 'CANTIDAD' => 3, 'USUARIO' => 10, 'METODO_PAGO' => 'Transferencia Bancaria'],
            ['DESCRIPCION' => 'Pago de suscripción anual', 'MONTO' => 130.00, 'CANTIDAD' => 1, 'USUARIO' => 10, 'METODO_PAGO' => 'Stripe'],
        ]);
    }
}
