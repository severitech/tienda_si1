<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Carrito;
use App\Models\DetalleCarrito;

class PasarelaPagos extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cart = session('cart', []);
        $lineItems = [];

        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'BOB',
                    'unit_amount' => $item['PRECIO'] * 100,
                    'product_data' => [
                        'name' => $item['NOMBRE'],
                    ],
                ],
                'quantity' => $item['CANTIDAD'],
            ];
        }

        $direccion = $request->input('direccion', 'Sin dirección');

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('stripe.success', ['direccion' => $direccion]),
            'cancel_url' => route('stripe.cancel'),
        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request)
    {
        $cart = session('cart', []);
        $direccion = $request->input('direccion', 'Sin dirección');
        $clienteId = Auth::id();

        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'El carrito está vacío.');
        }

        $carrito = Carrito::create([
            'DIRECCION' => $direccion,
            'ESTADO' => true,
            'CLIENTE' => $clienteId,
            'METODO_PAGO' => 'Tarjeta',
        ]);

        foreach ($cart as $productoId => $item) {
            DetalleCarrito::create([
                'CARRITO' => $carrito->ID,
                'PRODUCTO' => $productoId,
                'PRECIO' => $item['PRECIO'],
                'CANTIDAD' => $item['CANTIDAD'],
            ]);
        }

        session()->forget('cart');

        return redirect()->route('home')->with('success', 'Pago exitoso y pedido registrado.');
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'El pago fue cancelado.');
    }
}
