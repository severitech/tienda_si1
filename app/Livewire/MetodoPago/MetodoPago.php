<?php

namespace App\Livewire\MetodoPago;

use Livewire\Component;
use App\Models\MetodoPagos;

class MetodoPago extends Component
{
    public $metodoSeleccionado;
    protected $listeners = [
        'limpiar' => 'limpiar'
    ];
    public function render()
    {
        $metodo_pago = MetodoPagos::all();
        return view('livewire.metodo-pago.metodo-pago', compact('metodo_pago'));
    }

    public function limpiar()
    {
        $this->metodoSeleccionado = null;
    }
    public function actualizarMetodo()
    {
        $this->dispatch('enviarMetodoPagoVentas', $this->metodoSeleccionado);
    }


}
