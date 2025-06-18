<?php

namespace App\Livewire\DetalleCarrito;

use Livewire\Component;
use App\Models\DetalleCarrito;

class CarritoDetalle extends Component
{
    public $idcarrito;
    public function mount($idcarrito)
    {
        $this->idcarrito = $idcarrito;
    }
    public function render()
    {
        $detalle_carrito = $this->mostrarLista();
        return view('livewire.detalle-carrito.carrito-detalle', compact('detalle_carrito'));
    }
    public function mostrarLista()
    {
        return DetalleCarrito::query()
            ->join('PRODUCTO', 'DETALLE_CARRITO.PRODUCTO', '=', 'PRODUCTO.ID')
            ->select(
                'DETALLE_CARRITO.*',
                'PRODUCTO.NOMBRE as producto_nombre',
                'PRODUCTO.PRECIO as producto_precio'
            )
            ->where('DETALLE_CARRITO.CARRITO', $this->idcarrito)
            ->get();

    }
}
