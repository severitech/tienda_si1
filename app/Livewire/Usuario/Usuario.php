<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Usuario extends Component
{
    use WithPagination;

    public $perPage = 5;

    public function render()
    {
        // Asegúrate de usar la tabla correcta para obtener los usuarios
        $usuarios = User::orderBy('nombre')->paginate($this->perPage);

        // Usando DB para obtener roles
        $roles = DB::table('ROL')->pluck('ROL');

        // Pasar usuarios y roles a la vista
        return view('livewire.usuario.usuario-tabla', compact('usuarios', 'roles'));
    }
}
