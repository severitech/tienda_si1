<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;

class ProductoCompra extends Component
{
    public $search = '';
    public $producto_id;
    public $stock_actual = 0;
    public $stock_comprar = 0;
    public $stock = 0;
    public $precio_proveedor = 0;
    public $mostrarResultados = true;

    public function render()
    {
        $productos = $this->obtenerProductos();
        return view('livewire.productos.producto-compra', compact('productos'));
    }

    public function obtenerProductos()
    {
        return Producto::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRE', 'like', '%' . $this->search . '%')
                ->orWhere('CATEGORIA', 'like', '%' . $this->search . '%');
        })
            ->where('ESTADO', true)
            ->where('CANTIDAD', '>=', 0)
            ->orderBy('NOMBRE')
            ->get(); 
    }

    public function guardarProducto($id)
    {
        $producto = Producto::find($id);

        if (!$producto) {
            return;
        }

        $this->producto_id = $producto->ID;
        $this->precio_proveedor = $producto->COSTO_UNITARIO ?? $producto->PRECIO;
        $this->search = $producto->CATEGORIA . ' ' . $producto->NOMBRE;
        $this->stock_actual = $producto->CANTIDAD;
        $this->stock = $this->stock_actual + $this->stock_comprar;
        $this->mostrarResultados = false;

        $this->dispatch('productoSeleccionado', $producto->ID);
    }

    public function stockaumentar()
    {
        $this->stock = intval($this->stock_actual) + intval($this->stock_comprar);
    }

    public function agregarProducto()
    {
        if (!$this->producto_id || $this->stock_comprar <= 0) {
            return;
        }

        $subtotal = $this->precio_proveedor * $this->stock_comprar;

        $this->dispatch('enviarProductoCompra', [
            'id' => $this->producto_id,
            'cantidad' => $this->stock_comprar,
            'precio' => $this->precio_proveedor,
            'subtotal' => $subtotal,
        ]);

        $this->reset([
            'search',
            'producto_id',
            'stock_comprar',
            'precio_proveedor',
            'stock_actual',
            'stock',
            'mostrarResultados'
        ]);
    }
}
