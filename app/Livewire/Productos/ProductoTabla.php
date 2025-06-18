<?php
namespace App\Livewire\Productos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Support\Facades\DB;

class ProductoTabla extends Component
{
    use WithPagination;

    public $producto = '', $categorias, $precio, $cantidad, $estado = null;

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
    public function cambiarEstado($id)
    {
        //dd($id);
        $dato = Producto::find($id);
        $dato->ESTADO = $dato->ESTADO == 1 ? 0 : 1;
        $dato->save();

    }

    public function updatedEstado($value)
    {
        $this->estado = is_numeric($value) ? (int) $value : null;
    }

    public function buscarProductos()
    {
        return Producto::query()
            ->join('CATEGORIA', 'PRODUCTO.CATEGORIA', '=', 'CATEGORIA.CATEGORIA')
            ->select('PRODUCTO.*', DB::raw("CATEGORIA.CATEGORIA"))
            ->where(function ($query) {
                $query
                    ->when(
                        $this->producto,
                        fn($q) =>
                        $q->where('PRODUCTO.NOMBRE', 'like', '%' . $this->producto . '%')
                    )
                    ->when(
                        $this->categorias,
                        fn($q) =>
                        $q->where('CATEGORIA.CATEGORIA', 'like', '%' . $this->categorias . '%')
                    )
                    ->when($this->precio !== null && $this->precio !== '', function ($q) {
                        // Aquí filtro por precio mayor o igual
                        $q->where('PRODUCTO.PRECIO', '!=', $this->precio);
                    })
                    ->when(
                        $this->cantidad,
                        fn($q) =>
                        $q->where('PRODUCTO.CANTIDAD', $this->cantidad)
                    )
                    ->when($this->estado !== null && $this->estado !== '', function ($q) {
                        $estadoBool = $this->estado == '1' ? 1 : 0;
                        $q->where('PRODUCTO.ESTADO', '=', $estadoBool);
                    });
            })
            ->orderBy('PRODUCTO.NOMBRE', 'asc')
            ->paginate($this->perPage);
    }

}
