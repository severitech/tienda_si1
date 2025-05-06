<?php

namespace App\Livewire\Usuario;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuario extends Component
{
    use WithPagination;

    public $users;
    public $nombre, $paterno, $materno, $telefono, $email, $password, $estado = true, $ROL, $user_id;
    public $isEditMode = false;
    public $perPage = 5;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    protected function validateRules()
    {
        return [
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'required|string|max:100',
            'telefono' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,' . $this->user_id,
            'password' => $this->user_id ? 'nullable|min:6' : 'required|min:6',
            'ROL' => 'nullable|string',
        ];
    }

    public function render()
    {
        $usuarios = User::where(function ($query) {
            $query->where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('paterno', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        })->orderBy('nombre')->paginate($this->perPage);

        $roles = DB::table('ROL')->pluck('ROL');

        return view('livewire.usuario.usuario-tabla', compact('usuarios', 'roles'));
    }

    public function crear()
    {
        $this->resetInputs();
        $this->dispatch('abrir-modal');
    }

    public function editar($id)
    {
        $usuario = User::findOrFail($id);

        $this->user_id = $usuario->id;
        $this->nombre = $usuario->nombre;
        $this->paterno = $usuario->paterno;
        $this->materno = $usuario->materno;
        $this->telefono = $usuario->telefono;
        $this->email = $usuario->email;
        $this->ROL = $usuario->ROL;
        $this->estado = $usuario->estado;
        $this->password = '';
    }

    public function guardar()
    {
        $this->validate($this->validateRules());

        if ($this->user_id) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        User::create([
            'nombre' => $this->nombre,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'estado' => $this->estado,
            'ROL' => $this->ROL,
        ]);

        $this->dispatch('cerrar-modal');
        $this->resetInputs();
        session()->flash('message', 'Usuario creado correctamente.');
    }

    public function update()
    {
        $user = User::findOrFail($this->user_id);

        $user->update([
            'nombre' => $this->nombre,
            'paterno' => $this->paterno,
            'materno' => $this->materno,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'estado' => $this->estado,
            'ROL' => $this->ROL,
        ]);

        $this->dispatch('cerrar-modal');
        $this->resetInputs();
        session()->flash('message', 'Usuario actualizado correctamente.');
    }

    public function toggleEstado($id)
    {
        $user = User::findOrFail($id);
        $user->estado = !$user->estado;
        $user->save();

        session()->flash('message', 'Estado del usuario actualizado correctamente.');
    }

    public function resetInputs()
    {
        $this->nombre = '';
        $this->paterno = '';
        $this->materno = '';
        $this->telefono = '';
        $this->email = '';
        $this->password = '';
        $this->estado = true;
        $this->ROL = '';
        $this->user_id = null;
        $this->isEditMode = false;
    }
}
