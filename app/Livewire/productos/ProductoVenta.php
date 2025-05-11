<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ProductoVenta extends Component
{
    use WithPagination;
    public $search = '';
    public $producto_id;
    public $perPage = 10;
    public $cantidadInput = 1;
    public $precio = 0;  // Asegura que tenga un valor por defecto
    public $subtotal = 0; // Para almacenar el subtotal
    public function render()
    {
        $productos = $this->obtenerProductos();
        return view('livewire.productos.producto-venta', compact('productos'));

    }
    public function obtenerProductos()
    {
        return Producto::where(function ($query) {
            $query->where('CODIGO', 'like', '%' . $this->search . '%')
                ->orWhere('NOMBRE', 'like', '%' . $this->search . '%')
                ->orWhere('CATEGORIA', 'like', '%' . $this->search . '%');
        })->where('ESTADO', true)
            ->where('CANTIDAD', '>', 0)
            ->orderBy('NOMBRE')
            ->paginate($this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function guardarProducto($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            $this->producto_id = $id; // Guardas el ID del cliente seleccionado
            $this->precio = $producto->PRECIO; // Guardas el precio del producto seleccionado
            $this->search = $producto->CATEGORIA . ' ' . $producto->NOMBRE ; // Muestra el nombre completo
            $this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            $this->dispatch('productoSeleccionado', $producto->id);
        } else {
            // session()->flash('message', 'Producto no encontrado.');
        }
    }


    public function agregarProducto()
    {
        $this->subtotal = $this->cantidadInput * $this->precio;

        // Enviar el producto seleccionado al componente padre
        $this->dispatch('enviarProducto', [
            'id' => $this->producto_id,
            'cantidad' => $this->cantidadInput,
            'precio' => $this->precio,
            'subtotal' => $this->subtotal,
        ]);
        // Reinicia los valores después de agregar el producto
        $this->reset(['search','producto_id', 'cantidadInput', 'precio', 'subtotal']);
        // session()->flash('message', 'IdProducto' . $this->producto_id . ' ' . $this->precio . 'Cantidad: ' . $this->cantidadInput . ' Subtotal: ' . $this->subtotal);
    
    }



}
