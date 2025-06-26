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

        $filename = 'reporte_compras_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($compras) {
            $file = fopen('php://output', 'w');
            
            // Encabezados del CSV
            fputcsv($file, [
                'Fecha',
                'Nro de Compra',
                'Trabajador',
                'Proveedor',
                'Método de Pago',
                'Total',
                'Estado'
            ]);

            // Datos de las compras
            foreach ($compras as $compra) {
                fputcsv($file, [
                    $compra->created_at ? $compra->created_at->format('d/m/Y H:i') : '-',
                    $compra->ID,
                    $compra->usuario ? $compra->usuario->nombre . ' ' . $compra->usuario->paterno . ' ' . $compra->usuario->materno : '-',
                    $compra->proveedor ? $compra->proveedor->NOMBRE : '-',
                    $compra->METODO_PAGO,
                    number_format($compra->TOTAL, 2),
                    $compra->ESTADO ? 'Activo' : 'Inactivo'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
