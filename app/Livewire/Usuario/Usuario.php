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
    public $search = '';

    // Se resetea la página cuando se cambia el texto de búsqueda
    public function updatedSearch()
    {
        $this->resetPage();
    }

    // Método para obtener los usuarios filtrados
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

    public function render()
    {
        // Llamamos a la función para obtener los usuarios
        $usuarios = $this->getUsuarios();

        // Usamos DB para obtener los roles (o puedes definir un modelo para roles)
        $roles = DB::table('ROL')->pluck('ROL');

        // Pasamos los datos a la vista
        return view('livewire.usuario.usuario-tabla', compact('usuarios', 'roles'));
    }

    //metodo para activar o desactivar el usuario
    public function cambiarEstado($id)
    {
        $usuario = User::find($id);

        if ($usuario) {
            $usuario->estado = !$usuario->estado; 
            $usuario->save();
        }
        session()->flash('success', 'Se cambió el estado');


    }

}
