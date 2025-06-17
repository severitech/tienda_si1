<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteVentaProducto extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $fecha_inicio;
    public $fecha_fin;
    public $producto_id = '';
    public $cantidad_minima = '';
    public $cantidad_maxima = '';
    public $orden_campo = 'created_at';
    public $orden_direccion = 'desc';
    public $productos = [], $total_ventas = 0, $total_cantidad = 0;

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
    }

    public function updated($propertyName)
    {
        $this->resetPage();
    }

    public function ordenarPor($campo)
    {
        if ($this->orden_campo === $campo) {
            $this->orden_direccion = $this->orden_direccion === 'asc' ? 'desc' : 'asc';
        } else {
            $this->orden_campo = $campo;
            $this->orden_direccion = 'asc';
        }

        $this->resetPage();
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

        $this->resetPage();
    }

    private function queryBase()
    {
        return DB::table('VENTA as v')
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
            )
            ->when($this->fecha_inicio, fn($q) => $q->whereDate('v.created_at', '>=', $this->fecha_inicio))
            ->when($this->fecha_fin, fn($q) => $q->whereDate('v.created_at', '<=', $this->fecha_fin))
            ->when($this->producto_id, fn($q) => $q->where('p.ID', $this->producto_id))
            ->when($this->cantidad_minima, fn($q) => $q->where('dv.CANTIDAD', '>=', $this->cantidad_minima))
            ->when($this->cantidad_maxima, fn($q) => $q->where('dv.CANTIDAD', '<=', $this->cantidad_maxima))
            ->orderBy($this->columnasOrdenables[$this->orden_campo] ?? 'v.created_at', $this->orden_direccion);
    }

    public function exportarPDF()
    {
        $ventas = $this->queryBase()->get();
        $this->total_ventas = $ventas->sum('subtotal');
        $this->total_cantidad = $ventas->sum('cantidad');
        $productos = Producto::where('ESTADO', 1)->get();

        $pdf = Pdf::loadView('reportes.reporte-venta-pdf', [
            'ventas' => $ventas,
            'total_ventas' => $this->total_ventas,
            'total_cantidad' => $this->total_cantidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'productos' => $productos,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'reporte_ventas_' . now()->format('Ymd_His') . '.pdf');
    }

    public function render()
    {
        $ventas = $this->queryBase()->paginate($this->perPage);
        $this->total_ventas = collect($ventas->items())->sum('subtotal');
        $this->total_cantidad = collect($ventas->items())->sum('cantidad');

        return view('livewire.ventas.reporte-venta-producto', [
            'ventas' => $ventas,
            'total' => $this->total_ventas,
            'cantidad' => $this->total_cantidad,
        ]);
    }
}
