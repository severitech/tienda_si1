<?php

namespace App\Livewire\Proveedor;

use Livewire\Component;
use App\Models\Proveedor;

class BuscarCompra extends Component
{
    public $search = '';
    public $id_proveedor;
    public $mostrarResultados = true;
    protected $listeners = [
        'limpiar' => 'limpiar'
    ];
    public function render()
    {
        $proveedores = $this->getProveedores()->get();
        return view('livewire.proveedor.buscar-compra', compact('proveedores'));
    }

    public function getProveedores()
    {
        return Proveedor::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%');
        })
            ->orderBy('nombre');
            
    }
    public function limpiar()
    {
        $this->search = '';
        $this->id_proveedor = null;
        $this->mostrarResultados = true; // mostrar la lista
    }
    public function updatingSearch()
    {
        $this->mostrarResultados = true; // Mostrar resultados otra vez si se escribe algo nuevo
    }
    

    public function guardarProveedor($id)
    {
        $proveedor = Proveedor::find($id);
        if ($proveedor) {
            $this->id_proveedor = $proveedor->ID; // Guardas el ID del cliente seleccionado
            $this->search = $proveedor->NOMBRE; // Muestra el nombre completo
            $this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            $this->dispatch('proveedorSeleccionadoCompra', $proveedor->ID);
              session()->flash('message', 'Proveedor asignado correctamente.');
        } else {
            session()->flash('message', 'Proveedor no encontrado.');
        }
        
    }
}
