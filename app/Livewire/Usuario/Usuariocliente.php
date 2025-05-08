<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Usuariocliente extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 10;
    public function render()
    {
        $usuarios = $this->getUsuarios();

        // Usamos DB para obtener los roles (o puedes definir un modelo para roles)
        $roles = DB::table('ROL')->pluck('ROL');


        return view('livewire.usuario.usuariocliente', compact('usuarios', 'roles'));
    }
    public function getUsuarios()
    {
        return User::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('paterno', 'like', '%' . $this->search . '%')
                ->orWhere('materno', 'like', '%' . $this->search . '%')
                ->orWhere('telefono', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })
            ->orderBy('nombre')
            ->paginate($this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
}
