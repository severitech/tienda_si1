<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteVentaProducto extends Component
{
    public $fecha_inicio;
    public $fecha_fin;
    public $producto_id = '';
    public $cantidad_minima = '';
    public $cantidad_maxima = '';
    public $orden_campo = 'created_at';
    public $orden_direccion = 'desc';
    public $productos = [];
    public $ventas = [];
    public $total_ventas = 0;
    public $total_cantidad = 0;

    protected $columnasOrdenables = [
        'created_at' => 'v.created_at',
        'fecha_venta' => 'v.created_at',
        'total_venta' => 'v.TOTAL',
        'codigo_producto' => 'p.CODIGO',
        'nombre_producto' => 'p.NOMBRE',
        'precio_unitario' => 'dv.PRECIO',
        'cantidad' => 'dv.CANTIDAD',
        'nombre_usuario' => 'u.nombre',
        'nombre_cliente' => 'c.nombre',
    ];


    public function mount()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->productos = Producto::where('ESTADO', 1)->get();
        $this->generarReporte();
    }

    public function updatedFechaInicio()
    {
        $this->generarReporte();
    }

    public function updatedFechaFin()
    {
        $this->generarReporte();
    }

    public function updatedProductoId()
    {
        $this->generarReporte();
    }

    public function updatedCantidadMinima()
    {
        $this->generarReporte();
    }

    public function updatedCantidadMaxima()
    {
        $this->generarReporte();
    }

    public function ordenarPor($campo)
    {
        if ($this->orden_campo === $campo) {
            $this->orden_direccion = $this->orden_direccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orden_campo = $campo;
            $this->orden_direccion = 'asc';
        }
        $this->generarReporte();
    }

    public function generarReporte()
    {
        $query = DB::table('VENTA as v')
            ->join('DETALLE_VENTA as dv', 'v.id', '=', 'dv.VENTA')
            ->join('PRODUCTO as p', 'dv.PRODUCTO', '=', 'p.ID')
            ->leftJoin('users as u', 'v.USUARIO', '=', 'u.id')
            ->leftJoin('users as c', 'v.CLIENTE', '=', 'c.id')
            ->select(
                'v.id as venta_id',
                'v.created_at as fecha_venta',
                'v.TOTAL as total_venta',
                'p.CODIGO as codigo_producto',
                'p.NOMBRE as nombre_producto',
                'dv.PRECIO as precio_unitario',
                'dv.CANTIDAD as cantidad',
                DB::raw('(dv.PRECIO * dv.CANTIDAD) as subtotal'),
                'u.nombre as nombre_usuario',
                'c.nombre as nombre_cliente'
            );

        // Filtro por rango de fechas
        if ($this->fecha_inicio) {
            $query->whereDate('v.created_at', '>=', $this->fecha_inicio);
        }

        if ($this->fecha_fin) {
            $query->whereDate('v.created_at', '<=', $this->fecha_fin);
        }

        // Filtro por producto
        if ($this->producto_id) {
            $query->where('p.ID', $this->producto_id);
        }

        // Filtro por cantidad
        if ($this->cantidad_minima) {
            $query->where('dv.CANTIDAD', '>=', $this->cantidad_minima);
        }

        if ($this->cantidad_maxima) {
            $query->where('dv.CANTIDAD', '<=', $this->cantidad_maxima);
        }

        // Ordenamiento (corregido)
        $campoOrden = $this->columnasOrdenables[$this->orden_campo] ?? 'v.created_at';
        $query->orderBy($campoOrden, $this->orden_direccion);

        $this->ventas = $query->get();

        // Calcular totales
        $this->total_ventas = $this->ventas->sum('subtotal');
        $this->total_cantidad = $this->ventas->sum('cantidad');
    }


    public function limpiarFiltros()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->producto_id = '';
        $this->cantidad_minima = '';
        $this->cantidad_maxima = '';
        $this->orden_campo = 'created_at';
        $this->orden_direccion = 'desc';
        $this->generarReporte();
    }

    public function exportarPDF()
    {
        $this->generarReporte(); // ya carga las ventas
        $productos = Producto::where('ESTADO', 1)->get(); // ← AÑADE ESTO

        $pdf = Pdf::loadView('reportes.reporte-venta-pdf', [
            'ventas' => $this->ventas,
            'total_ventas' => $this->total_ventas,
            'total_cantidad' => $this->total_cantidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'productos' => $productos, // ← Y PASA ESTO A LA VISTA
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'reporte_ventas_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        return view('livewire.ventas.reporte-venta-producto');
    }
}