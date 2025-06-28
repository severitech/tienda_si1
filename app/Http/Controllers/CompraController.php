<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use PDF;

class CompraController extends Controller
{
    public function mostrar()
    {
        return view('trabajador.compra.mostrar');
    }

    public function reporteCompras(Request $request)
    {
        $query = Compra::query()->with('usuario');

        if ($request->filled('nro')) {
            $query->where('id', $request->nro);
        }
        if ($request->filled('cliente')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('metodo_pago')) {
            $query->where('METODO_PAGO', $request->metodo_pago);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $compras = $query->paginate(10);

        return view('reporte.compras.index', compact('compras'));
    }

    public function exportarPdf(Request $request)
    {
        $query = Compra::query()->with('usuario');

        if ($request->filled('nro')) {
            $query->where('id', $request->nro);
        }
        if ($request->filled('cliente')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('metodo_pago')) {
            $query->where('METODO_PAGO', $request->metodo_pago);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $compras = $query->get();

        $pdf = PDF::loadView('reporte.compras.pdf', compact('compras'));
        return $pdf->download('reporte_compras.pdf');
    }

    public function exportarExcel(Request $request)
    {
        $query = Compra::query()->with(['usuario', 'proveedor']);

        if ($request->filled('nro')) {
            $query->where('ID', $request->nro);
        }
        if ($request->filled('cliente')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('metodo_pago')) {
            $query->where('METODO_PAGO', $request->metodo_pago);
        }
        if ($request->filled('estado')) {
            $query->where('ESTADO', $request->estado);
        }

        $compras = $query->get();

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
                $compra->usuario ? $compra->usuario->nombre . ' ' . $compra->usuario->paterno . ' ' . $compra->usuario->materno : '-',
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

    public function exportarHtml(Request $request)
    {
        $query = Compra::query()->with(['usuario', 'proveedor']);

        if ($request->filled('nro')) {
            $query->where('ID', $request->nro);
        }
        if ($request->filled('cliente')) {
            $query->whereHas('usuario', function ($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->cliente . '%');
            });
        }
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }
        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }
        if ($request->filled('metodo_pago')) {
            $query->where('METODO_PAGO', $request->metodo_pago);
        }
        if ($request->filled('estado')) {
            $query->where('ESTADO', $request->estado);
        }

        $compras = $query->get();

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
        $compra = Compra::findOrFail($id);
        $compra->ESTADO = false;
        $compra->save(); 
        return redirect()->route('reporte.compras')->with('success', 'Compra eliminada correctamente.');
    }


    public function detalle($id)
    {
        $compra = Compra::with(['usuario', 'proveedor'])->findOrFail($id);
        $detalles = DetalleCompra::where('COMPRA', $id)->with('producto')->get();
        return view('reporte.compras.detalle', compact('compra', 'detalles'));
    }
}
