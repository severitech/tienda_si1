<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use Stripe\Stripe;
use Stripe\Webhook;
use Stripe\Checkout\Session as StripeSession;
/* \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

                $lineItems = [];
                foreach ($cart as $id => $item) {
                    $lineItems[] = [
                        'price_data' => [
                            'currency' => 'BOB',
                            'unit_amount' => intval($item['PRECIO'] * 100),
                            'product_data' => [
                                'name' => $item['NOMBRE'],
                            ],
                        ],
                        'quantity' => $item['CANTIDAD'],
                    ];
                }

                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'success_url' => route('stripe.success'),
                    'cancel_url' => route('stripe.cancel'),
                    'client_reference_id' => Auth::id(),
                    'metadata' => [
                        'cart' => json_encode($cart),
                        'direccion' => $request->input('direccion', 'Sin dirección'),
                    ],
                ]);*/
class PasarelaPagos extends Controller
{
    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar la compra.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        // Crear el registro principal del carrito
        $carrito = Carrito::create([
            'DIRECCION' => $request->input('direccion', 'Sin dirección'),
            'ESTADO' => true,
            'CLIENTE' => Auth::id(),
            'METODO_PAGO' => 'Tarjeta' // O manual
        ]);

        // Guardar cada producto del carrito en DETALLE_CARRITO
        foreach ($cart as $productoId => $item) {
            DetalleCarrito::create([
                'CARRITO' => $carrito->ID,
                'PRODUCTO' => $productoId,
                'PRECIO' => $item['PRECIO'],
                'CANTIDAD' => $item['CANTIDAD']
            ]);
        }

        // Limpiar el carrito de la sesión
        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Pedido registrado con éxito');
    }





    public function success()
    {
        session()->forget('cart');
        return redirect()->route('home')->with('success', 'Pago exitoso');
    }


    public function cancel()
    {
        return redirect()->route('home')->with('error', 'El pago fue cancelado.');
    }
}
