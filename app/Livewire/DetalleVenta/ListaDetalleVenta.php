<?php

namespace App\Livewire\DetalleVenta;

use Livewire\Component;
use App\Models\DetalleVenta;
use App\Models\Venta;
use App\Models\Producto;

class ListaDetalleVenta extends Component
{
    public $idventa;

    public function mount($idventa)
    {
        $this->idventa = $idventa;
    }
    public function render()
    {
        $detalle_venta = $this->mostrarLista();

        return view('livewire.detalle-venta.lista-detalle-venta', compact('detalle_venta'))
            ->extends('layouts.app')
            ->section('content');
    }

    public function mostrarLista()
    {
        return DetalleVenta::query()
            ->join('producto', 'detalle_venta.producto', '=', 'producto.id')
            ->select(
                'detalle_venta.*',
                'producto.nombre as producto_nombre',
                'producto.precio as producto_precio'
            )
            ->where('detalle_venta.venta', $this->idventa)
            ->get();
    }

    

}
