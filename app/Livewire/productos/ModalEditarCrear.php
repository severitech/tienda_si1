<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;

class ModalEditarCrear extends Component
{
    protected $listeners = ['abrirModalEditar' => 'cargarProducto'];

    public $codigo, $nombre, $precio, $categoria_id, $imagen, $estado = false;
    public $producto_id = null;
    public function cargarProducto($id)
    {
        $producto = Producto::findOrFail($id);

        $this->codigo = $producto->CODIGO;
        $this->nombre = $producto->NOMBRE;
        $this->precio = $producto->PRECIO;
        $this->categoria = $producto->CATEGORIA;
    }
    public function guardar()
    {
        $producto = $this->producto_id
            ? Producto::findOrFail($this->producto_id)
            : new Producto();

        $producto->CODIGO = $this->codigo;
        $producto->NOMBRE = $this->nombre;
        $producto->PRECIO = $this->precio;
        $producto->CATEGORIA = $this->categoria;
        $producto->ESTADO = true;

        if ($this->imagen) {
            $producto->IMAGEN = $this->imagen->store('productos', 'public');
        }

        $producto->save();

        $this->emit('productoActualizado');
    }

    public function render()
    {
        return view('livewire.productos.modal-editar-crear');
    }
}
