<?php

use Livewire\Component;

class ProductoModal extends Component
{
    public $productoId;
    public $codigo, $nombre, $precio, $categoria;

    protected $listeners = ['editarProducto' => 'cargarProducto'];

    public function cargarProducto($producto)
    {
        $this->productoId = $producto['ID'];
        $this->codigo     = $producto['CODIGO'];
        $this->nombre     = $producto['NOMBRE'];
        $this->precio     = $producto['PRECIO'];
        $this->categoria  = $producto['CATEGORIA'];
    }

    public function render()
    {
        return view('livewire.producto-modal');
    }

    public function guardar()
    {
        // Guardar en BD...
    }
}
