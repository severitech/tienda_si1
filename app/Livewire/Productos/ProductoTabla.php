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
        $productos = $this->buscarProductos();

        return view('livewire.productos.producto-tabla', compact('productos'));
    }
    public function buscarProductos()
    {
        return Producto::where('CATEGORIA', 'like', '%' . $this->search . '%')
        ->orWhere('NOMBRE', 'like', '%' . $this->search . '%')
        ->orWhere('CODIGO', 'like', '%' . $this->search . '%')
        
        ->orderBy('NOMBRE')
        ->paginate($this->perPage);
    }
}
