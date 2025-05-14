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
            ->join('producto', 'detalle_carrito.producto', '=', 'producto.id')
            ->select(
                'detalle_carrito.*',
                'producto.nombre as producto_nombre',
                'producto.precio as producto_precio'
            )
            ->where('detalle_carrito.carrito', $this->idcarrito)
            ->get();
    }
}
