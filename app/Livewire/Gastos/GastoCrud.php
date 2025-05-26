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

    public $usuarios = [];
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
        $this->usuarios = User::all();
        $this->metodosPago = MetodoPago::all();


        $gastos = Gasto::where('DESCRIPCION', 'like', '%' . $this->search . '%')->paginate(10);
        return view('livewire.gastos.gasto-crud', compact('gastos'));
    }

    public function limpiar()
    {
        $this->reset(['descripcion', 'monto', 'cantidad', 'usuario', 'metodo_pago', 'gasto_id']);
    }

    public function guardarNuevo()
    {
        $this->validate();

        Gasto::Create([
            'DESCRIPCION' => $this->descripcion,
            'MONTO' => $this->monto,
            'CANTIDAD' => $this->cantidad,
            'USUARIO' => $this->usuario,
            'METODO_PAGO' => $this->metodo_pago,
        ]);

        $this->limpiar();
        $this->dispatch('cerrar-modal');
    }
    public function guardarActualizado()
    {

        $this->validate();

        $gasto = Gasto::find($this->gasto_id);
    
        $gasto->update([
            'ID' => $this->gasto_id,
            'DESCRIPCION' => $this->descripcion,
            'MONTO' => $this->monto,
            'CANTIDAD' => $this->cantidad,
            'USUARIO' => $this->usuario,
            'METODO_PAGO' => $this->metodo_pago,
        ]);

        $this->limpiar();
        $this->dispatch('cerrar-modal');
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
