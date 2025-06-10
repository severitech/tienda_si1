<?php
namespace App\Livewire\Productos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;
use App\Models\Categoria;

class ProductoTabla extends Component
{
    use WithPagination;

    public $producto, $categorias, $precio, $cantidad, $estado = true;

    public function exportarPdf()
    {
        $query = http_build_query([
            'nombre' => $this->producto,
            'categoria' => $this->categorias,
            'precio' => $this->precio,
            'cantidad' => $this->cantidad,
            'estado' => $this->estado,
        ]);

        return redirect()->to(route('productos.exportar-pdf') . '?' . $query);
    }
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
        $categoria = Categoria::all();
        return view('livewire.productos.producto-tabla', compact('productos', 'categoria'));
    }
    public function buscarProductos()
    {
        $query = Producto::query();

        if ($this->categorias) {
            $query->where('CATEGORIA', 'like', '%' . $this->categorias . '%');
        }
        if ($this->producto) {
            $query->where('NOMBRE', 'like', '%' . $this->producto . '%');
        }
        if ($this->precio) {
            $query->where('PRECIO', $this->precio);
        }
        if ($this->cantidad) {
            $query->where('CANTIDAD', $this->cantidad);
        }
        if ($this->estado !== null && $this->estado !== '') {
            $query->where('ESTADO', $this->estado);
        }

        return $query->orderBy('NOMBRE')->paginate($this->perPage);
    }
    
}
