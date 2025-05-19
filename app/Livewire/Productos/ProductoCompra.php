<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;

class ProductoCompra extends Component
{
    public $search = '';
    public $producto_id;
    public $stock_actual= 0;
    public $stock_comprar = 0;  // Asegura que tenga un valor por defecto
    public $stock = 0; // Para almacenar el subtotal
    public $precio_proveedor = 0;
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
        })->where('ESTADO', true)
            ->where('CANTIDAD', '>=', 0)
            ->orderBy('NOMBRE')
            ->GET();
    }


    public function guardarProducto($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $this->producto_id = $id; // Guardas el ID del cliente seleccionado
            $this->precio = $producto->PRECIO; // Guardas el precio del producto seleccionado
            $this->search = $producto->CATEGORIA . ' ' . $producto->NOMBRE; // Muestra el nombre completo
            $this->stock_actual = $producto->CANTIDAD;
            $this->stock = $this->stock_actual + $this->stock_comprar;
            $this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            $this->dispatch('productoSeleccionado', $producto->ID);
         //  session()->flash('message', 'IdProducto' . $this->producto_id . '  actual' . $this->stock_actual . ' a comprar: ' . $this->stock_comprar . ' Total: ' . $this->stock. 
   //     ' precio proveedor'. $this->precio_proveedor);
        } else {
            // session()->flash('message', 'Producto no encontrado.');
        }
    }

    public function stockaumentar(){
        $this->stock = $this->stock_actual + $this->stock_comprar;
    }

    public function agregarProducto()
    {
        //$this->subtotal = $this->cantidadInput * $this->precio;
        
        // Enviar el producto seleccionado al componente padre
        $this->dispatch('enviarProductoCompra', [
            'id' => $this->producto_id,
            'cantidad' => $this->stock_comprar,
            'precio' => $this->precio_proveedor,
            'subtotal' => $this->precio_proveedor*$this->stock_comprar,
        ]);
        // Reinicia los valores después de agregar el producto
        $this->reset(['search', 'producto_id', 'stock_comprar', 'precio_proveedor', 'stock_actual']);
        // session()->flash('message', 'IdProducto' . $this->producto_id . ' ' . $this->precio . 'Cantidad: ' . $this->cantidadInput . ' Subtotal: ' . $this->subtotal);*/

    }



}
