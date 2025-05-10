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
    public $cliente_id;
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

    public function guardarUsuario($id)
    {
        $usuario = User::find($id);
        if ($usuario) {
            $this->cliente_id = $usuario->id; // Guardas el ID del cliente seleccionado
            $this->search = $usuario->nombre . ' ' . $usuario->paterno . ' ' . $usuario->materno; // Muestra el nombre completo
            $this->mostrarResultados = false; // Oculta la lista
            // Enviar el cliente seleccionado al componente padre
            $this->dispatch('clienteSeleccionado', $usuario->id);
          //  session()->flash('message', 'Usuario asignado correctamente.');
        } else {
            session()->flash('message', 'Usuario no encontrado.');
        }
    }
}
