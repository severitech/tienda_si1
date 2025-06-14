<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = Venta::all();
        return view('trabajador.venta.index', compact('ventas'));
    }
    public function mostrar()
    {
        return view('trabajador.venta.mostrar');
    }
    public function listaventas()
    {
        return view('trabajador.venta.lista-ventas');
    }
    public function exportarPdf(Request $request)
    {
        $query = Venta::query()
            ->join('users as cliente', 'VENTA.cliente', '=', 'cliente.id')
            ->join('users as usuario', 'VENTA.usuario', '=', 'usuario.id')
            ->select(
                'VENTA.*',
                DB::raw("cliente.nombre as cliente_nombre"),
                DB::raw("cliente.paterno as cliente_paterno"),
                DB::raw("cliente.materno as cliente_materno"),
                DB::raw("usuario.nombre as usuario_nombre")
            )
            ->where(function ($q) use ($request) {
                if ($request->idventa) {
                    $q->where('VENTA.id', 'like', '%' . $request->idventa . '%');
                }
                if ($request->cliente) {
                    $q->where(DB::raw("cliente.nombre || ' ' || cliente.paterno || ' ' || cliente.materno"), 'like', '%' . $request->cliente . '%');
                }
                if ($request->vendedor) {
                    $q->where(DB::raw("usuario.nombre || ' ' || usuario.paterno || ' ' || usuario.materno"), 'like', '%' . $request->vendedor . '%');
                }
                if ($request->metodo_pago) {
                    $q->where('VENTA.metodo_pago', 'like', '%' . $request->metodo_pago . '%');
                }
                if ($request->fecha_inicio) {
                    $q->whereDate('VENTA.created_at', '>=', $request->fecha_inicio);
                }
                if ($request->fecha_fin) {
                    $q->whereDate('VENTA.created_at', '<=', $request->fecha_fin);
                }
                if ($request->estado !== null && $request->estado !== '') {
                    $estadoBool = $request->estado == '1' ? true : false;
                    $q->where('VENTA.estado', '=', $estadoBool);
                }
            })
            ->orderBy('VENTA.id', 'desc')
            ->get();

        $pdf = Pdf::loadView('reportes.ventas-pdf', compact('query'));

        return $pdf->download('ventas-filtradas.pdf');
    }
    public function exportarPdfVenta(Request $request)
    {
        $ventas = Venta::with(['cliente', 'usuario'])->orderBy('created_at', 'desc')->get();
    
        $pdf = Pdf::loadView('trabajador.venta.pdf', compact('ventas'));
    
        return $pdf->download('reporte_ventas.pdf');
    }
}
