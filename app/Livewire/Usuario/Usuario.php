<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Usuario extends Component
{
    use WithPagination;

    public $nombre, $paterno, $materno, $telefono, $email, $password, $rol, $estado = true;
    public $perPage = 5;
    public $search = '';
    public $usuario_id;

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
    // guardar usuarios
    public function guardar()
    {
        if ($this->usuario_id) {
            $usuario = User::findOrFail($this->usuario_id);

            $usuario->update([
                "nombre" => $this->nombre,
                "paterno" => $this->paterno,
                "materno" => $this->materno,
                "telefono" => $this->telefono,
                "email" => $this->email,
                "password" => bcrypt($this->password),
                "ROL" => $this->rol,
                "estado" => $this->estado,
            ]);
        } else {
            User::create([
                "nombre" => $this->nombre,
                "paterno" => $this->paterno,
                "materno" => $this->materno,
                "telefono" => $this->telefono,
                "email" => $this->email,
                "password" => bcrypt($this->password),
                "ROL" => $this->rol,
                "estado" => true,
            ]);
        }



        session()->flash('message', $this->usuario_id ? 'Usuario actualizado con éxito.' : 'Usuario creado con éxito.');
        $this->reset([
            'usuario_id',
            'nombre',
            'paterno',
            'materno',
            'telefono',
            'email',
            'password',
            'rol',
            'estado',
        ]);
        // Puedes cerrar el modal aquí con JS o evento Livewire si quieres
        $this->dispatch('cerrarModal');
    }


    public function editar($id)
    {
        $usuario = User::findOrFail($id); // o tu modelo de usuarios

        $this->usuario_id = $usuario->id;
        $this->nombre = $usuario->nombre;
        $this->paterno = $usuario->paterno;
        $this->materno = $usuario->materno;
        $this->email = $usuario->email;
        $this->telefono = $usuario->telefono;
        $this->rol = $usuario->rol;

        // Si deseas también puedes emitir un evento para abrir el modal desde JS si es necesario
        $this->dispatch('abrirModal'); // ← Solo si lo necesitas con JS
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

        if (!$usuario) {
            session()->flash('message', 'Usuario no encontrado.');
            return;
        }

        $usuario->estado = !$usuario->estado;
        $usuario->save();

        // Emitir evento para mostrar la alerta con el nombre del usuario
        session()->flash('message', "Estado de {$usuario->nombre} cambiado con éxito.");
    }
}
