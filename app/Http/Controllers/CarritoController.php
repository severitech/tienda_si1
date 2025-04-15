<?php

namespace App\Http\Controllers;

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
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'El carrito está vacío');
        }

        $carrito = Carrito::create([
            'DIRECCION' => $request->input('direccion', 'Sin dirección'),
            'ESTADO' => true,
            'CLIENTE' => Auth::id(),
            'METODO_PAGO' => $request->input('metodo_pago', 'EFECTIVO')
        ]);

        foreach ($cart as $productId => $item) {
            DetalleCarrito::create([
                'CARRITO' => $carrito->ID,
                'PRODUCTO' => $productId,
                'PRECIO' => $item['PRECIO'],
                'CANTIDAD' => $item['CANTIDAD']
            ]);
        }

        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Pedido realizado con éxito');
    }
}
