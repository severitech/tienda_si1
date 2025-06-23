<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Comentario;
use Carbon\Carbon;

class ComentariosTabla extends Component
{
    use WithPagination;

    public $search = '';
    public $filtroFecha = '';
    public $filtroCliente = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'filtroFecha' => ['except' => ''],
        'filtroCliente' => ['except' => ''],
        'sortField' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFiltroFecha()
    {
        $this->resetPage();
    }

    public function updatingFiltroCliente()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filtroFecha', 'filtroCliente']);
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function render()
    {
        $comentarios = Comentario::query()
            ->with(['user', 'carrito'])
            ->when($this->search, function ($query) {
                $query->where('comentario', 'like', '%' . $this->search . '%')
                    ->orWhereHas('user', function ($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%')
                          ->orWhere('paterno', 'like', '%' . $this->search . '%')
                          ->orWhere('materno', 'like', '%' . $this->search . '%')
                          ->orWhere('email', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->filtroFecha, function ($query) {
                $fecha = Carbon::parse($this->filtroFecha);
                $query->whereDate('created_at', $fecha);
            })
            ->when($this->filtroCliente, function ($query) {
                $query->whereHas('user', function ($q) {
                    $q->where('nombre', 'like', '%' . $this->filtroCliente . '%')
                      ->orWhere('paterno', 'like', '%' . $this->filtroCliente . '%')
                      ->orWhere('materno', 'like', '%' . $this->filtroCliente . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.comentarios-tabla', [
            'comentarios' => $comentarios
        ]);
    }
}
