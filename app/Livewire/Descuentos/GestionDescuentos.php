<?php

namespace App\Livewire\Descuentos;

use Livewire\Component;
use App\Models\Descuento;
use App\Models\Producto;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Collection;
    use App\Exports\DescuentosExport; // Deberás crear esta clase
    use Maatwebsite\Excel\Facades\Excel;
    use Barryvdh\DomPDF\Facade\Pdf;  

class GestionDescuentos extends Component
{
    use WithPagination;


    public $isOpen = false;
    public $descuentoId, $nombre, $descripcion, $tipo = 'fijo', $valor, $activo = true;
    public $productos_seleccionados = []; // Para asignar a productos
    public $allProductos;

    public function render()
    {
        $descuentos = Descuento::with('productos')->paginate(10);
        return view('livewire.descuentos.gestion-descuentos', [
            'descuentos' => $descuentos,
        ]);
    }

     public function create()
    {
        $this->resetInputFields();
        $this->allProductos = Producto::all(); // Cargar productos para el selector
        $this->openModal();
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'tipo' => 'required',
            'valor' => 'required|numeric',
            'productos_seleccionados' => 'required|array|min:1'
        ]);

        $descuento = Descuento::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'tipo' => $this->tipo,
            'valor' => $this->valor,
            'activo' => $this->activo,
        ]);

        $descuento->productos()->sync($this->productos_seleccionados);

        session()->flash('message', 'Descuento creado exitosamente.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $descuento = Descuento::findOrFail($id);
        $this->descuentoId = $id;
        $this->nombre = $descuento->nombre;
        // ... (cargar los demás campos)
        $this->productos_seleccionados = $descuento->productos->pluck('id')->toArray();
        $this->allProductos = Producto::all();
        $this->openModal();
    }
    
    // ... aquí irían las funciones update() y delete()

    public function openModal() { $this->isOpen = true; }
    public function closeModal() { $this->isOpen = false; }
    private function resetInputFields(){ /* resetea todos los campos del formulario */ }

    public function exportarExcel()
    {
        return Excel::download(new DescuentosExport, 'descuentos.xlsx');
    }

    public function exportarPdf()
    {
        $descuentos = Descuento::all();
        $pdf = PDF::loadView('reportes.descuentos-pdf', compact('descuentos'));
        return $pdf->download('descuentos.pdf');
    }


}
