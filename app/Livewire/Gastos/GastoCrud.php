<?php

namespace App\Livewire\Gastos;

use Livewire\Component;
use App\Models\Gasto;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\MetodoPago;

class GastoCrud extends Component
{
    use WithPagination;

    public $descripcion, $monto, $cantidad, $usuario, $metodo_pago;
    public $gasto_id;
    public $search = '';

    public $metodosPago = [];

    protected $rules = [
        'descripcion' => 'required|string',
        'monto' => 'required|numeric',
        'cantidad' => 'required|integer',
        'usuario' => 'required|exists:users,id',
        'metodo_pago' => 'required|exists:METODO_PAGO,METODO_PAGO',
    ];

    public function render()
    {
        $this->metodosPago = MetodoPago::all();

        $gastos = Gasto::where('DESCRIPCION', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.gastos.gasto-crud', compact('gastos'));
    }

    public function limpiar()
    {
        $this->reset(['descripcion', 'monto', 'cantidad', 'usuario', 'metodo_pago', 'gasto_id']);
    }

    public function guardar()
    {
      //  $this->validate();
      // $this->limpiar();
      //  dd(auth()->id());

        if ($this->gasto_id) {
            // Si existe, actualiza
            Gasto::where('ID', $this->gasto_id)->update([
                'DESCRIPCION' => $this->descripcion,
                'MONTO' => $this->monto,
                'CANTIDAD' => $this->cantidad,
                'USUARIO' => auth()->id(),
                'METODO_PAGO' => $this->metodo_pago,
            ]);
        } else {
            // Si no, crea uno nuevo
            Gasto::create([
                'DESCRIPCION' => $this->descripcion,
                'MONTO' => $this->monto,
                'CANTIDAD' => $this->cantidad,
                'USUARIO' => auth()->id(),
                'METODO_PAGO' => $this->metodo_pago,
            ]);
        }

        $this->limpiar();
        session()->flash('message', 'Gasto guardado correctamente.');
        $this->dispatch('cerrar-modal');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }



    public function editar($id)
    {
        $gasto = Gasto::findOrFail($id);
        $this->gasto_id = $gasto->ID;
        $this->descripcion = $gasto->DESCRIPCION;
        $this->monto = $gasto->MONTO;
        $this->cantidad = $gasto->CANTIDAD;
        $this->usuario = $gasto->USUARIO;
        $this->metodo_pago = $gasto->METODO_PAGO;

    }

    public function eliminar($id)
    {
        Gasto::destroy($id);
    }
}
