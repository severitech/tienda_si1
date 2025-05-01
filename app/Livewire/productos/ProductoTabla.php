<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Producto;

class ProductoTabla extends Component
{
    use WithPagination;

    public $search = ''; // Propiedad para la búsqueda
    public $perPage = 10;

    public function render()
    { 
        $productos = Producto::where('NOMBRE', 'like', '%' . $this->search . '%')
                            ->orderBy('NOMBRE')
                            ->paginate($this->perPage);
        return view('livewire.productos.producto-tabla', compact('productos'));
    }
    
}

