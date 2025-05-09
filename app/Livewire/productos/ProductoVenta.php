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
    public $cantidad = 1; // Asegura que tenga un valor por defecto
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
            $this->producto_id = $producto->id; // Guardas el ID del cliente seleccionado
            $this->precio = $producto->PRECIO; // Guardas el precio del producto seleccionado
            $this->search = $producto->CATEGORIA . ' ' . $producto->NOMBRE . ' ' . $producto->PRECIO; // Muestra el nombre completo
            //$this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            // $this->dispatch('productoSeleccionado', $producto->id);
            session()->flash('message', 'Producto asignado correctamente.');
        } else {
            session()->flash('message', 'Producto no encontrado.');
        }
    }



    public function updatedCantidad($value)
    {
        $this->cantidad = max(1, (int) $value); // Asegura que cantidad sea siempre mayor o igual a 1
        $this->calcularSubtotal();
    }

    // Método que se ejecuta automáticamente cuando se actualiza 'precio'
    public function updatedPrecio($value)
    {
        $this->precio = max(1, (float) $value); // Asegura que precio sea siempre mayor o igual a 1
        $this->calcularSubtotal();
    }

    // Método para calcular el subtotal
    public function calcularSubtotal()
    {
        $this->subtotal = $this->cantidad * $this->precio; // Actualiza el subtotal con la nueva cantidad y precio
    }



}
