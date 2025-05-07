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
        $cantidad = $request->input('cantidad', 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['CANTIDAD'] += $cantidad;
        } else {
            $cart[$id] = [
                "NOMBRE" => $producto->NOMBRE,
                "CANTIDAD" => $cantidad,
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

    
}
