<?php

namespace App\Livewire\Descuento;

use Livewire\Component;
use App\Models\Descuento;
use App\Models\Producto;
use Livewire\WithPagination;

class GestionDescuentos extends Component
{
    use WithPagination;

    public $descuentoId, $nombre, $descripcion, $tipo = 'porcentaje', $valor, $inicia_en, $termina_en;
    public $esta_activo = true;
    public $productosSeleccionados = [];
    public $esModalAbierto = false;

    public function render()
    {
        return view('livewire.descuento.gestion-descuentos', [
            'descuentos' => Descuento::latest()->paginate(10),
            'productos' => Producto::orderBy('NOMBRE')->get()
        ]);
    }

    public function abrirModal() {
        $this->limpiarEntradas();
        $this->esModalAbierto = true;
    }

    public function cerrarModal() {
        $this->esModalAbierto = false;
    }

    private function limpiarEntradas() {
        $this->descuentoId = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->tipo = 'porcentaje';
        $this->valor = '';
        $this->inicia_en = '';
        $this->termina_en = '';
        $this->esta_activo = true;
        $this->productosSeleccionados = [];
    }

    public function guardar() {
        $this->validate([
            'nombre' => 'required|string|max:255',
            'tipo' => 'required|in:porcentaje,fijo',
            'valor' => 'required|numeric|min:0',
            'inicia_en' => 'required|date',
            'termina_en' => 'required|date|after_or_equal:inicia_en',
            'productosSeleccionados' => 'required|array|min:1'
        ]);

        $descuento = Descuento::updateOrCreate(['id' => $this->descuentoId], [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'valor' => $this->valor,
            'inicia_en' => $this->inicia_en,
            'termina_en' => $this->termina_en,
            'esta_activo' => $this->esta_activo,
        ]);

        $descuento->productos()->sync($this->productosSeleccionados);

        session()->flash('mensaje', $this->descuentoId ? 'Descuento actualizado con éxito.' : 'Descuento creado con éxito.');
        $this->cerrarModal();
    }

    public function editar($id) {
        $descuento = Descuento::findOrFail($id);
        $this->descuentoId = $id;
        $this->nombre = $descuento->nombre;
        $this->descripcion = $descuento->descripcion;
        $this->tipo = $descuento->tipo;
        $this->valor = $descuento->valor;
        $this->inicia_en = $descuento->inicia_en->format('Y-m-d\TH:i');
        $this->termina_en = $descuento->termina_en->format('Y-m-d\TH:i');
        $this->esta_activo = $descuento->esta_activo;
        $this->productosSeleccionados = $descuento->productos->pluck('id')->toArray();
        $this->abrirModal();
    }

    public function eliminar($id) {
        Descuento::find($id)->delete();
        session()->flash('mensaje', 'Descuento eliminado con éxito.');
    }

}
