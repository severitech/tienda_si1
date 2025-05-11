<?php

namespace App\Livewire\MetodoPago;

use Livewire\Component;
use App\Models\MetodoPago;

class MetodoPagoCrud extends Component
{
    public $metodo_pago;
    public $modoEdicion = false;
    public $metodo_original;

    public function render()
    {
        // Obtener todos los métodos de pago
        $metodos = MetodoPago::all();
        return view('livewire.metodo-pago.metodo-pago-crud', compact('metodos'));
    }


    public function guardar()
    {
        $this->validate([
            'metodo_pago' => 'required|string|max:50',
        ]);

        if ($this->modoEdicion) {
            // Modo edición: actualizar el método original
            MetodoPago::where('METODO_PAGO', $this->metodo_original)->update([
                'METODO_PAGO' => $this->metodo_pago,
            ]);

            session()->flash('message', 'Método de pago actualizado correctamente.');
        } else {
            // Modo creación
            $this->validate([
                'metodo_pago' => 'unique:METODO_PAGO,METODO_PAGO'
            ]);

            MetodoPago::create([
                'METODO_PAGO' => $this->metodo_pago,
            ]);

            session()->flash('message', 'Método de pago creado correctamente.');
        }

        // Limpiar estado
        $this->reset(['metodo_pago', 'modoEdicion', 'metodo_original']);
    }



    public function actualizarModal($METODO)
    {
        $metodo = MetodoPago::find($METODO);

        $this->metodo_pago = $metodo->METODO_PAGO;
        $this->metodo_original = $metodo->METODO_PAGO;
        $this->modoEdicion = true;

        // Aquí podrías emitir un evento para abrir el modal si usas JS
        $this->dispatch('abrirModalEditarCrear');
    }


  
    public function eliminar($METODO)
    {
        MetodoPago::destroy($METODO);
        session()->flash('message', $METODO . ' eliminado correctamente.');

        $this->metodo_pago = '';
    }
   
}
