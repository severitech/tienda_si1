<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Comentario;
use Illuminate\Support\Facades\Auth;

class EncuestaPostCompra extends Component
{
    public $comentario = '';
    public $carritoId;
    public $mostrarEncuesta = false;

    protected $rules = [
        'comentario' => 'nullable|string|max:1000'
    ];

    public function mount($carritoId = null)
    {
        $this->carritoId = $carritoId;
        $this->mostrarEncuesta = true;
    }

    public function guardarComentario()
    {
        $this->validate();

        if (!empty($this->comentario)) {
            Comentario::create([
                'carrito_id' => $this->carritoId,
                'user_id' => Auth::id(),
                'comentario' => $this->comentario
            ]);
        }

        $this->mostrarEncuesta = false;
        $this->comentario = '';
        
        session()->flash('message', '¡Gracias por tu comentario! Nos ayuda a mejorar nuestro servicio.');
        
        // Redirigir a home después de un breve delay
        $this->dispatch('redirect-to-home');
    }

    public function saltarEncuesta()
    {
        $this->mostrarEncuesta = false;
        session()->flash('message', '¡Gracias por tu compra!');
        
        // Redirigir a home después de un breve delay
        $this->dispatch('redirect-to-home');
    }

    public function render()
    {
        return view('livewire.encuesta-post-compra');
    }
}
