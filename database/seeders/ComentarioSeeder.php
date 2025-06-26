<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Comentario;
use App\Models\User;
use App\Models\Carrito;

class ComentarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comentarios = [
            [
                'comentario' => 'Excelente servicio, los productos llegaron en perfecto estado y muy rápido. Definitivamente volveré a comprar aquí.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'Muy buena experiencia de compra. La interfaz es fácil de usar y el proceso de pago fue muy sencillo.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'Los precios están muy buenos comparado con otras tiendas. Recomiendo ampliamente.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'Sería bueno tener más opciones de métodos de pago. Por lo demás todo perfecto.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'El envío fue rápido y el embalaje muy cuidado. Muy satisfecho con mi compra.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => null, // Cliente que no dejó comentario
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'Me gustaría que tengan más productos en stock. Los que compré eran exactamente lo que necesitaba.',
                'user_id' => null,
                'carrito_id' => null
            ],
            [
                'comentario' => 'La atención al cliente es excelente. Respondieron todas mis dudas rápidamente.',
                'user_id' => null,
                'carrito_id' => null
            ]
        ];

        foreach ($comentarios as $comentario) {
            Comentario::create($comentario);
        }
    }
}
