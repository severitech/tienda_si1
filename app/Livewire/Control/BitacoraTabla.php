<?php

namespace App\Livewire\Control;

use Livewire\Component;
use App\Models\Bitacora;
use Livewire\WithPagination;

class BitacoraTabla extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $logs = Bitacora::with('user') // Carga la relación con el usuario para eficiencia
            ->where(function($query) {
                $query->where('accion', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($subQuery) {
                          $subQuery->where('nombre', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest() // Ordena por los más recientes primero
            ->paginate(15); // Pagina los resultados

        return view('livewire.control.bitacora-tabla', [
            'logs' => $logs,
        ]);
    }
}