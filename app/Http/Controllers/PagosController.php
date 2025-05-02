<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagosController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        return view('pagos.index', compact('cart'));
    }

    public function create(Request $request)
    {
        if ($request->metodo_pago == 'tarjeta') {
            return;
        }
        $venta = venta::create([
            'TOTAL' => 0.0,
            'USUARIO' => Auth::user()->id,
            'CLIENTE' => Auth::user()->id,
            'METODO_PAGO' => $request->metodo_pago == 'efectivo' ? 'Efectivo' : 'QR',
        ]);
        $cart = session('cart', []);
        $montoTotal = 0;
        foreach ($cart as $id => $item) {
            $producto = Producto::find($id);
            $producto->update([
                'CANTIDAD'=>$producto->CANTIDAD-$item['CANTIDAD']
            ]);
            DetalleVenta::create([
                'VENTA' => $venta->id,
                'PRODUCTO' => $id,
                'PRECIO' => $item['PRECIO'],
                'CANTIDAD' => $item['CANTIDAD']
            ]);
            $montoTotal = $montoTotal + ($item['CANTIDAD']*$item['PRECIO']);
        }
        $venta->update([
            'TOTAL'=>$montoTotal
        ]);


        return redirect(route('home'));
    }
}   
 # "NOMBRE" => "Queso Fresco"
        #"CANTIDAD" => "1"
        #"PRECIO" => "3.50"
        #"IMAGEN" => "imagen3.jpg"