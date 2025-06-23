<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\venta;

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


        // }else{
        // #comentarios distintivo 
        // $venta = venta::create([
        //     'TOTAL' => 0.0,
        //     'USUARIO' => Auth::user()->id,
        //     'CLIENTE' => Auth::user()->id,
        //     'METODO_PAGO' => $request->metodo_pago == 'efectivo' ? 'Efectivo' : 'QR',
        // ]);
        // $cart = session('cart', []);
        // $montoTotal = 0;
        // foreach ($cart as $id => $item) {
        //     $producto = Producto::find($id);
        //     $producto->update([
        //         'CANTIDAD' => $producto->CANTIDAD - $item['CANTIDAD']
        //     ]);
        //     DetalleVenta::create([
        //         'VENTA' => $venta->id,
        //         'PRODUCTO' => $id,
        //         'PRECIO' => $item['PRECIO'],
        //         'CANTIDAD' => $item['CANTIDAD']
        //     ]);
        //     $montoTotal = $montoTotal + ($item['CANTIDAD'] * $item['PRECIO']);
        // }
        // $venta->update([
        //     'TOTAL' => $montoTotal
        // ]);

        // session()->forget('cart');
        // return redirect()->route('home')->with('success', 'Pago exitoso y pedido registrado.');
        // }
    }

   public function success(Request $request)
{
    $cart = session('cart', []);
    $direccion = $request->input('direccion', 'Sin dirección');
    $clienteId = Auth::id();

    if (empty($cart)) {
        return redirect()->route('home')->with('error', 'El carrito está vacío.');
    }

    // Crear el carrito con el TOTAL inicial como 0.00
    $carrito = Carrito::create([
        'TOTAL' => 0.00, // Total inicial
        'DIRECCION' => $direccion,
        'ESTADO' => true,
        'CLIENTE' => $clienteId,
        'METODO_PAGO' => 'Stripe',
    ]);

    // Calculamos el total
    $montoTotal = 0;

    // Insertar detalles del carrito
    foreach ($cart as $productoId => $item) {
        DetalleCarrito::create([
            'CARRITO' => $carrito->ID,
            'PRODUCTO' => $productoId,
            'PRECIO' => $item['PRECIO'],
            'CANTIDAD' => $item['CANTIDAD'],
        ]);

        // Calculamos el total
        $montoTotal += $item['PRECIO'] * $item['CANTIDAD'];
    }

    // Ahora actualizamos el carrito con el total calculado
    $carrito->TOTAL = $montoTotal;

    // Guardamos el carrito con el total actualizado
    $carrito->save();

    // Limpiar el carrito de la sesión
    session()->forget('cart');

    // Mostrar encuesta post compra
    return view('encuesta-post-compra', ['carritoId' => $carrito->ID]);
}









    public function cancel()
    {
        return redirect()->route('home')->with('error', 'El pago fue cancelado.');
    }
}
