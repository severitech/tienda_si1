<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\User;
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
            $query->whereHas('usuario', function($q) use ($request) {
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
            $query->whereHas('usuario', function($q) use ($request) {
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

    public function eliminar($id)
    {
        $compra = \App\Models\Compra::findOrFail($id);
        $compra->delete();
        return redirect()->route('reporte.compras')->with('success', 'Compra eliminada correctamente.');
    }

    public function detalle($id)
    {
        $compra = \App\Models\Compra::with(['usuario', 'proveedor'])->findOrFail($id);
        $detalles = \App\Models\DetalleCompra::where('COMPRA', $id)->with('producto')->get();
        return view('reporte.compras.detalle', compact('compra', 'detalles'));
    }
}
