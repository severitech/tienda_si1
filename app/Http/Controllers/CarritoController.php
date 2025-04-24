<?php

namespace App\Http\Controllers;

use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CarritoController extends Controller
{
    public function addToCart(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar la compra.');
        }
        $producto = Producto::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['CANTIDAD']++;
        } else {
            $cart[$id] = [
                "NOMBRE" => $producto->NOMBRE,
                "CANTIDAD" => 1,
                "PRECIO" => $producto->PRECIO,
                "IMAGEN" => $producto->IMAGEN
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Producto añadido al carrito');
    }

    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Producto eliminado del carrito');
    }

    public function checkout(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para finalizar la compra.');
        }
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }
        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
    
        foreach ($cart as $id => $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'bob',
                    'unit_amount' => intval($item['PRECIO'] * 100), // en centavos
                    'product_data' => [
                        'name' => $item['NOMBRE'],
                    ],
                ],
                'quantity' => $item['CANTIDAD'],
            ];
        }
    
        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [$lineItems],
            'mode' => 'payment',
            'success_url' => route('cart.success'),
            'cancel_url' => route('cart.index'),
        ]);
    
        $carrito = Carrito::create([
            'DIRECCION' => $request->input('direccion', 'Sin dirección'),
            'ESTADO' => true,
            'CLIENTE' => Auth::id(),
            'METODO_PAGO' => 'Tarjeta'
        ]);

        foreach ($cart as $id => $item) {
            DetalleCarrito::create([
                'CARRITO' => $carrito->ID,
                'PRODUCTO' => $id,
                'PRECIO' => $item['PRECIO'],
                'CANTIDAD' => $item['CANTIDAD']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Pedido realizado con éxito');
    }
}
