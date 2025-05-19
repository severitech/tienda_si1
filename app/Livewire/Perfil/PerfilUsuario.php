<?php

namespace App\Livewire\Perfil;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PerfilUsuario extends Component
{
    public $vista = 'perfil';
    public $nombre, $paterno, $materno, $telefono, $email;
    public $password_actual, $password_nueva, $password_confirmar;

    public function mount()
    {
        $user = Auth::user();
        $this->nombre = $user->NOMBRE;
        $this->paterno = $user->PATERNO;
        $this->materno = $user->MATERNO;
        $this->telefono = $user->TELEFONO;
        $this->email = $user->EMAIL;
    }

    public function actualizarPerfil()
    {
        $this->validate([
            'nombre' => 'required|string|max:100',
            'paterno' => 'required|string|max:100',
            'materno' => 'required|string|max:100',
            'telefono' => ['required', 'string', 'min:7', 'regex:/^[0-9+\-\s()]+$/'],
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        ]);

        Auth::user()->update([
            'nombre' => $this->NOMBRE,
            'paterno' => $this->PATERNO,
            'materno' => $this->MATERNO,
            'telefono' => $this->TELEFONO,
            'email' => $this->EMAIL,
        ]);

        session()->flash('mensaje_perfil', 'Perfil actualizado correctamente.');
    }

    public function actualizarPassword()
    {
        $this->validate([
            'password_actual' => 'required',
            'password_nueva' => 'required|min:8|same:password_confirmar',
            'password_confirmar' => 'required|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->password_actual, $user->password)) {
            return session()->flash('mensaje_password', 'La contraseña actual no es correcta.');
        }

        $user->update([
            'password' => Hash::make($this->password_nueva),
        ]);

        $this->reset(['password_actual', 'password_nueva', 'password_confirmar']);
        session()->flash('mensaje_password', 'Contraseña actualizada correctamente.');
    }

    public function render()
    {
        return view('livewire.perfil.perfil-usuario');
    }

    public function messages()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'paterno.required' => 'El campo apellido paterno es obligatorio.',
            'materno.required' => 'El campo apellido materno es obligatorio.',
            'telefono.required' => 'El campo teléfono es obligatorio.',
            'telefono.min' => 'El teléfono debe tener al menos 7 caracteres.',
            'telefono.regex' => 'El formato del teléfono no es válido.',
            'email.required' => 'El campo correo es obligatorio.',
            'email.email' => 'El formato del correo no es válido.',
            'email.unique' => 'Este correo ya está registrado.',
            'password_actual.required' => 'Debes ingresar tu contraseña actual.',
            'password_nueva.required' => 'Debes ingresar una nueva contraseña.',
            'password_nueva.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password_nueva.same' => 'La confirmación no coincide con la nueva contraseña.',
            'password_confirmar.required' => 'Debes confirmar la nueva contraseña.',
            'password_confirmar.min' => 'La confirmación debe tener al menos 8 caracteres.',
        ];
    }
}
