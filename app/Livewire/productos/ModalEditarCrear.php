<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;

class ModalEditarCrear extends Component
{
    public $ID, $codigo, $nombre, $precio, $categoria;
    protected $listeners = ['editarProducto' => 'editar'];

    public function editar($id)
    {
        $producto = Producto::findOrFail($id);

        $this->ID = $producto->ID;
        $this->codigo = $producto->CODIGO;
        $this->nombre = $producto->NOMBRE;
        $this->precio = $producto->PRECIO;
        $this->categoria = $producto->CATEGORIA;

        // Aquí podrías usar JavaScript para abrir el modal, si es necesario
        $this->dispatch('abrirModal');
    }

    public function render()
    {
        return view('livewire.productos.modal-editar-crear');
    }
}
