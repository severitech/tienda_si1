<?php

namespace App\Livewire\MetodoPago;

use Livewire\Component;
use App\Models\MetodoPagos;

class MetodoPago extends Component
{
    public $metodoSeleccionado;
    public function render()
    {
        $metodo_pago = MetodoPagos::all();
        return view('livewire.metodo-pago.metodo-pago', compact('metodo_pago'));
    }


    public function actualizarMetodo()
    {
        $this->dispatch('enviarMetodoPagoVentas', $this->metodoSeleccionado);
    }

}
