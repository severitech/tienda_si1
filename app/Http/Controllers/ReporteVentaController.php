<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\DetalleVenta;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteVentaController extends Controller
{

    public function reporte(){
        return view('trabajador.venta.reporteventaproductos');
    }

    public function exportarPDF(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio', Carbon::now()->subMonth()->format('Y-m-d'));
        $fechaFin = $request->get('fecha_fin', Carbon::now()->format('Y-m-d'));
        $buscarProducto = $request->get('producto', '');
        $cantidadMinima = $request->get('cantidad_minima', 0);

        // Construir la consulta
        $query = DetalleVenta::with(['PRODUCTO', 'VENTA'])
            ->whereHas('VENTA', function($q) use ($fechaInicio, $fechaFin) {
                $q->whereBetween('created_at', [
                    $fechaInicio . ' 00:00:00',
                    $fechaFin . ' 23:59:59'
                ]);
            })
            ->where('CANTIDAD', '>=', $cantidadMinima);

        // Filtrar por producto si se especifica
        if (!empty($buscarProducto)) {
            $query->whereHas('PRODUCTO', function($q) use ($buscarProducto) {
                $q->where('NOMBRE', 'like', '%' . $buscarProducto . '%')
                  ->orWhere('CODIGO', 'like', '%' . $buscarProducto . '%');
            });
        }

        $ventas = $query->orderBy('created_at', 'desc')->get();
        
        // Calcular total
        $totalVentas = $ventas->sum(function($detalle) {
            return $detalle->PRECIO * $detalle->CANTIDAD;
        });

        $data = [
            'ventas' => $ventas,
            'totalVentas' => $totalVentas,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin,
            'buscarProducto' => $buscarProducto,
            'cantidadMinima' => $cantidadMinima,
            'fechaGeneracion' => Carbon::now()->format('d/m/Y H:i:s')
        ];

        $pdf = Pdf::loadView('reportes.reporte-venta-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        $nombreArchivo = 'reporte_ventas_' . $fechaInicio . '_' . $fechaFin . '.pdf';
        
        return $pdf->download($nombreArchivo);
    }

}
