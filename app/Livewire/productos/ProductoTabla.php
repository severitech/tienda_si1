<?php
namespace App\Livewire\Productos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;

class ProductoTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    public $modalAbierto = false;
    public $productoId = null;

    protected $listeners = ['cerrarModal'];

    public function cerrarModal()
    {
        $this->modalAbierto = false;
    }
    public function updatingPage()
    {
        $this->cerrarModal();
    }
    public function abrirModalEditar($id)
    {
        $this->productoId = $id;
        $this->modalAbierto = true;
    }

    public function abrirModalCrear()
    {
        $this->productoId = null;
        $this->modalAbierto = true;
    }

    public function render()
    {
        $productos = Producto::where('NOMBRE', 'like', '%' . $this->search . '%')
            ->orderBy('NOMBRE')
            ->paginate($this->perPage);

        return view('livewire.productos.producto-tabla', compact('productos'));
    }
}
