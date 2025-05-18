<?php

namespace App\Livewire\Proveedor;

use Livewire\Component;
use App\Models\Proveedor;
use Livewire\WithPagination;

class Listaproveedor extends Component
{
    use WithPagination;

    public $perPage = 5;
    public $nombre, $telefono;
    public $id_proveedor;

    public function mount()
    {
        $this->resetForm();
    }

    public function render()
    {
        $proveedores = Proveedor::orderBy('nombre')->paginate($this->perPage);
        return view('livewire.proveedor.listaproveedor', compact('proveedores'));
    }

    public function editar($id)
    {
        $proveedor = Proveedor::find($id);

        if ($proveedor) {
            $this->nombre = $proveedor->NOMBRE;
            $this->telefono = $proveedor->TELEFONO;
            $this->id_proveedor = $proveedor->ID;
        }
    }

    public function guardar()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
            'telefono' => ['required', 'string', 'min:7', 'regex:/^[0-9+\-\s()]+$/'],
        ]);

        $proveedor = $this->id_proveedor
            ? Proveedor::findOrFail($this->id_proveedor)
            : new Proveedor();

        $proveedor->NOMBRE = $this->nombre;
        $proveedor->TELEFONO = $this->telefono;
        $proveedor->save();

        session()->flash('message', $this->id_proveedor ? 'Proveedor actualizado' : 'Proveedor creado');

        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset(['nombre', 'telefono', 'id_proveedor']);
    }
}
