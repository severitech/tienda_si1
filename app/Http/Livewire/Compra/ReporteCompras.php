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

    public function exportarExcel()
    {
        $compras = $this->getComprasQuery()->get();
        
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Reporte de Compras');

        // Encabezados
        $sheet->fromArray([
            'ID',
            'Fecha',
            'Trabajador',
            'Proveedor',
            'Método de Pago',
            'Total',
            'Estado'
        ], null, 'A1');

        // Cuerpo
        $row = 2;
        foreach ($compras as $compra) {
            $sheet->fromArray([
                $compra->ID,
                $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-',
                $compra->usuario ? $compra->usuario->nombre . ' ' . $compra->usuario->paterno : '-',
                $compra->proveedor ? $compra->proveedor->NOMBRE : '-',
                $compra->METODO_PAGO,
                $compra->TOTAL,
                $compra->ESTADO ? 'Activo' : 'Inactivo'
            ], null, 'A' . $row);
            $row++;
        }

        // Descargar
        $filename = 'reporte_compras_' . now()->format('Ymd_His') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function exportarHTML()
    {
        $compras = $this->getComprasQuery()->get();
        
        $html = view('reporte.compras.html', compact('compras'))->render();
        
        $filename = 'reporte_compras_' . date('Y-m-d_H-i-s') . '.html';
        
        $headers = [
            'Content-Type' => 'text/html',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response($html, 200, $headers);
    }

    public function eliminar($id)
    {
        $compra = Compra::find($id);
        if ($compra) {
            $compra->estado = false;
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