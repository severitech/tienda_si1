<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;

class ProductoCompra extends Component
{public $search = '';
    public $producto_id;
    public $perPage = 10;
    public $stock_actual = 0;
    public $stock_comprar = 1;  // Asegura que tenga un valor por defecto
    public $stock = 0; // Para almacenar el subtotal
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
            ->where('CANTIDAD', '>', 0)
            ->orderBy('NOMBRE');
    }


    public function guardarProducto($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $this->producto_id = $id; // Guardas el ID del cliente seleccionado
            $this->precio = $producto->PRECIO; // Guardas el precio del producto seleccionado
            $this->search = $producto->CATEGORIA . ' ' . $producto->NOMBRE; // Muestra el nombre completo
            $this->stock = $producto->CANTIDAD;
            $this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            $this->dispatch('productoSeleccionado', $producto->id);
        } else {
            // session()->flash('message', 'Producto no encontrado.');
        }
    }


    public function agregarProducto()
    {
        /*$this->subtotal = $this->cantidadInput * $this->precio;

        // Enviar el producto seleccionado al componente padre
        $this->dispatch('enviarProducto', [
            'id' => $this->producto_id,
            'cantidad' => $this->cantidadInput,
            'precio' => $this->precio,
            'subtotal' => $this->subtotal,
        ]);
        // Reinicia los valores después de agregar el producto
        $this->reset(['search', 'producto_id', 'cantidadInput', 'precio', 'subtotal']);
        // session()->flash('message', 'IdProducto' . $this->producto_id . ' ' . $this->precio . 'Cantidad: ' . $this->cantidadInput . ' Subtotal: ' . $this->subtotal);*/

    }



}
