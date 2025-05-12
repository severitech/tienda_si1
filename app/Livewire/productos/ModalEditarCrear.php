<?php
namespace App\Livewire\Productos;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Producto;
use App\Models\Categoria;

class ModalEditarCrear extends Component
{
    use WithFileUploads;

    public $productoId;
    public $codigo, $nombre, $precio, $cantidad = 0, $categoria, $imagen, $estado = true;

    public $categorias = [];

    public function mount($productoId = null)
    {
        $this->categorias = Categoria::all(); // Cargar lista de categorías

        if ($productoId) {
            $producto = Producto::findOrFail($productoId);
            $this->productoId = $producto->ID;
            $this->codigo = $producto->CODIGO;
            $this->nombre = $producto->NOMBRE;
            $this->precio = $producto->PRECIO;
            $this->cantidad = $producto->CANTIDAD ?? 0;
            $this->categoria = $producto->CATEGORIA;
            $this->estado = $producto->ESTADO;
        }
    }

    public function guardar()
    {
        $this->validate([
            'codigo' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'cantidad' => 'required|integer|min:0',
            'categoria' => 'required|string|max:255',
            'imagen' => 'nullable|image|max:2048',
        ]);

        $producto = $this->productoId
            ? Producto::findOrFail($this->productoId)
            : new Producto();

        $producto->CODIGO = $this->codigo;
        $producto->NOMBRE = $this->nombre;
        $producto->PRECIO = $this->precio;
        $producto->CANTIDAD = $this->cantidad;
        $producto->CATEGORIA = $this->categoria;
        $producto->ESTADO = $this->estado;

        if ($this->imagen) {
            $producto->IMAGEN = $this->imagen->store('productos', 'public');
        }

        $producto->save();

        $this->dispatch('cerrarModal');
    }

    public function render()
    {
        return view('livewire.productos.modal-editar-crear');
    }
}
