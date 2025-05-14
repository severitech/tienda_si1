<?php

namespace App\Livewire\Categoria;

use Livewire\Component;
use App\Models\Categoria;
use Livewire\WithPagination;
class CategoriaCrud extends Component
{

    use WithPagination;
    public $perPage = 5;
    public $search = '';
    public $categoria;
    public $modoEdicion = false;
    public $categoria_original;
    public function render()
    {
        $categorias = $this->obtenerCategorias();
        return view('livewire.categoria.categoria-crud', compact('categorias'));
    }
    public function obtenerCategorias()
    {
        return Categoria::where('CATEGORIA', 'like', '%' . $this->search . '%')
            ->OrderBy('CATEGORIA')
            ->paginate($this->perPage);
    }

    public function actualizarModal($prop)
    {
        $metodo = Categoria::where('CATEGORIA', $prop)->firstOrFail();

        $this->categoria = $metodo->CATEGORIA;
        $this->categoria_original = $metodo->CATEGORIA;
        $this->modoEdicion = true;

        $this->dispatch('abrirModalEditarCrear');
    }

    public function guardar()
    {


        if ($this->modoEdicion) {
            Categoria::where('CATEGORIA', $this->categoria_original)->update([
                'CATEGORIA' => $this->categoria,
            ]);
            session()->flash('message', 'Categoría actualizada correctamente.');
        } else {
           

            Categoria::create([
                'CATEGORIA' => $this->categoria,
            ]);
            session()->flash('message', 'Categoría creada correctamente.');
        }

        $this->reset(['categoria', 'modoEdicion', 'categoria_original']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function eliminar($prop)
    {
        $catego = Categoria::where('CATEGORIA', $prop)->firstOrFail();
        $catego->delete();
        session()->flash('message', 'Categoría eliminada correctamente.');
    }

}
