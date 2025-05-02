<?php

namespace App\Livewire\Rol;

use Livewire\Component;
use App\Models\Rol;
class RolesModal extends Component
{
    public function render()
    {
        $rol = Rol::all();
        return view("livewire.rol.roles-modal", compact("rol"));
    }
}
