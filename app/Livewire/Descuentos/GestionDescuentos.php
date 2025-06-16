<?php

namespace App\Livewire\Descuentos;

use Livewire\Component;
use App\Models\Descuento;
use App\Models\Producto;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;

class GestionDescuentos extends Component
{
    use WithPagination;

    public $descuentoId, $nombre, $descripcion, $tipo = 'porcentaje', $valor, $inicia_en, $termina_en;
    public $esta_activo = true;
    public $esModalAbierto = false;
    
    public $productosSeleccionados = [];
    public string $busquedaProducto = '';

    // Propiedad computada para obtener los modelos de los productos seleccionados
    public function getProductosSeleccionadosModelosProperty(): Collection
    {
        if (empty($this->productosSeleccionados)) {
            return new Collection();
        }
        return Producto::whereIn('id', $this->productosSeleccionados)->get();
    }

    // Método para quitar un producto de la lista de seleccionados
    public function removerProducto($productoId): void
    {
        // Se asegura de que el ID sea un entero
        $productoId = (int) $productoId;
        $this->productosSeleccionados = array_values(array_diff($this->productosSeleccionados, [$productoId]));
    }

    // Método para AÑADIR un producto a la lista
    public function seleccionarProducto($productoId): void
    {
        // Se asegura de que el ID sea un entero
        $productoId = (int) $productoId;
        if (!in_array($productoId, $this->productosSeleccionados)) {
            $this->productosSeleccionados[] = $productoId;
        }
        $this->busquedaProducto = '';

        // Avisamos a Alpine.js que cierre el menú desplegable
        $this->dispatch('producto-seleccionado');
    }

    public function render()
    {
        $productosParaSeleccionar = collect(); // Inicia una colección vacía

        // Solo busca si hay texto en el campo de búsqueda
        if (strlen($this->busquedaProducto) >= 2) {
            $productosParaSeleccionar = Producto::query()
                ->where('NOMBRE', 'like', '%' . $this->busquedaProducto . '%')
                ->whereNotIn('id', $this->productosSeleccionados)
                ->limit(10)
                ->get();
        }

        return view('livewire.descuentos.gestion-descuentos', [
            'descuentos' => Descuento::latest()->paginate(10),
            'productosParaSeleccionar' => $productosParaSeleccionar,
        ])->layout('components.layouts.app');
    }

    public function crear()
    {
        $this->limpiarEntradas();
        $this->esModalAbierto = true;
    }
    
    public function cerrarModal()
    {
        $this->esModalAbierto = false;
        $this->limpiarEntradas();
    }

    private function limpiarEntradas()
    {
        $this->reset(['descuentoId', 'nombre', 'descripcion', 'tipo', 'valor', 'inicia_en', 'termina_en', 'esta_activo', 'productosSeleccionados', 'busquedaProducto']);
    }

    public function guardar()
    {
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

    public function editar($id)
    {
        $descuento = Descuento::with('productos')->findOrFail($id);
        $this->descuentoId = $id;
        $this->nombre = $descuento->nombre;
        $this->descripcion = $descuento->descripcion;
        $this->tipo = $descuento->tipo;
        $this->valor = $descuento->valor;
        $this->inicia_en = $descuento->inicia_en->format('Y-m-d\TH:i');
        $this->termina_en = $descuento->termina_en->format('Y-m-d\TH:i');
        $this->esta_activo = $descuento->esta_activo;
        $this->productosSeleccionados = $descuento->productos->pluck('id')->toArray();
        $this->esModalAbierto = true;
    }

    public function eliminar($id)
    {
        Descuento::find($id)->delete();
        session()->flash('mensaje', 'Descuento eliminado con éxito.');
    }
}
