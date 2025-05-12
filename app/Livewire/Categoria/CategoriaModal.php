<?php

namespace App\Livewire\Categoria;

use Livewire\Component;
use App\Models\Categoria;

class CategoriaModal extends Component
{
    public function render()
    {
        $categoria = Categoria::all();
        return view('livewire.categoria.categoria-modal', compact('categoria'));
    }


}
