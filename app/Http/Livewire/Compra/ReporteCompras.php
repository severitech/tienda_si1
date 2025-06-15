<?php

namespace App\Http\Livewire\Compra;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Compra;
use App\Models\DetalleCompra;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteCompras extends Component
{
    use WithPagination;

    public $search = '';
    public $fechaInicio = '';
    public $fechaFin = '';
    public $compra;
    public $detalles = [];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportarPDF()
    {
        $compras = $this->getComprasQuery()->get();
        
        $pdf = PDF::loadView('livewire.compra.reporte-compras-pdf', [
            'compras' => $compras
        ]);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'reporte-compras.pdf');
    }

    public function eliminar($id)
    {
        $compra = Compra::find($id);
        if ($compra) {
            $compra->delete();
            session()->flash('message', 'Compra eliminada correctamente');
        }
    }

    public function mostrarDetalle($id)
    {
        $this->compra = Compra::with(['usuario', 'proveedor'])->find($id);
        $this->detalles = DetalleCompra::where('COMPRA', $id)->with('producto')->get();
        $this->dispatch('open-modal', 'detalle-compra');
    }

    protected function getComprasQuery()
    {
        $query = Compra::with(['usuario', 'proveedor'])
            ->when($this->search, function($query) {
                $query->where(function($q) {
                    $q->whereHas('usuario', function($q) {
                        $q->where('nombre', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('proveedor', function($q) {
                        $q->where('NOMBRE', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('ID', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->fechaInicio, function($query) {
                $query->whereDate('created_at', '>=', $this->fechaInicio);
            })
            ->when($this->fechaFin, function($query) {
                $query->whereDate('created_at', '<=', $this->fechaFin);
            })
            ->orderBy('created_at', 'desc');

        return $query;
    }

    public function render()
    {
        $compras = $this->getComprasQuery()->paginate(10);
        return view('livewire.compra.reporte-compras', compact('compras'));
    }
} 