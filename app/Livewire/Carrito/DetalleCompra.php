<?php

namespace App\Livewire\Carrito;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DetalleCompra extends Component
{
    public function render()
    {
        $carritos = DB::table('CARRITO')
            ->where('CLIENTE', auth()->id())
            ->get();

        $detalles = DB::table('DETALLE_CARRITO')
            ->join('PRODUCTO', 'DETALLE_CARRITO.PRODUCTO', '=', 'PRODUCTO.ID')
            ->whereIn('DETALLE_CARRITO.CARRITO', $carritos->pluck('ID'))
            ->select(
                'DETALLE_CARRITO.CARRITO',
                'PRODUCTO.NOMBRE',
                'DETALLE_CARRITO.CANTIDAD',
                'DETALLE_CARRITO.PRECIO'
            )
            ->get()
            ->groupBy('CARRITO');

        $detalleCompra = [];

        foreach ($carritos as $carrito) {
            $productos = collect($detalles[$carrito->ID] ?? []); // Convertir a colección

            // Calcular total
            $total = $productos->reduce(function ($carry, $item) {
                return $carry + ($item->CANTIDAD * $item->PRECIO);
            }, 0);

            $detalleCompra[$carrito->ID] = [
                'carrito' => $carrito,
                'productos' => $productos,
                'total' => $total,
            ];
        }

        return view('livewire.carrito.detalle-compra', compact('detalleCompra'))
            ->extends('layouts.app')
            ->section('content');
    }
}
