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
            ->join('PRODUCTO', 'detalle_venta.producto', '=', 'PRODUCTO.id')
            ->select(
                'detalle_venta.*',
                \DB::raw('PRODUCTO.NOMBRE as producto_nombre'),
                \DB::raw('PRODUCTO.PRECIO as producto_precio')
            )
            ->where('detalle_venta.venta', $this->idventa)
            ->get();
    }
}