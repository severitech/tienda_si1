<?php

namespace App\Livewire\Control;

use Livewire\Component;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Livewire\WithPagination;
use Barryvdh\DomPDF\Facade\Pdf;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class HistorialMovimientos extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $fecha_inicio;
    public $fecha_fin;
    public $producto_id = '';
    public $tipo = '';
    public $orden_campo = 'created_at';
    public $orden_direccion = 'desc';
    public $productos = [], $total_ventas = 0, $total_cantidad = 0;


    public function mount()
    {
        $this->fecha_inicio = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->fecha_fin = Carbon::now()->format('Y-m-d');
        $this->productos = Producto::where('ESTADO', 1)->get();
        $this->tipo = '';
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
        $this->tipo = '';

        $this->resetPage();
    }

    private function queryBase()
    {
        // Subconsulta: ventas confirmadas
        $ventas = DB::table('VENTA as v')
            ->join('DETALLE_VENTA as dv', 'v.id', '=', 'dv.VENTA')
            ->join('PRODUCTO as p', 'dv.PRODUCTO', '=', 'p.ID')
            ->leftJoin('users as u', 'v.USUARIO', '=', 'u.id')
            ->select(
                DB::raw("'Venta' as tipo_movimiento"),
                'v.created_at as fecha_movimiento',
                'v.TOTAL as total_mov',
                'p.CODIGO as codigo_producto',
                'p.NOMBRE as nombre_producto',
                'dv.PRECIO as precio_unitario',
                'dv.CANTIDAD as cantidad',
                DB::raw('(dv.PRECIO * dv.CANTIDAD) as subtotal'),
                'u.nombre as nombre_usuario'
            )
            ->when($this->fecha_inicio, fn($q) => $q->whereDate('v.created_at', '>=', $this->fecha_inicio))
            ->when($this->fecha_fin, fn($q) => $q->whereDate('v.created_at', '<=', $this->fecha_fin))
            ->when($this->producto_id, fn($q) => $q->where('p.ID', $this->producto_id))
            ->when($this->tipo, fn($q) => $q->where('tipo_movimiento', '=', $this->tipo))
            ->orderBy('fecha_movimiento', 'desc');

        // Subconsulta: compras (ingresos al inventario)
        $compras = DB::table('COMPRA as c')
            ->join('DETALLE_COMPRA as dc', 'c.id', '=', 'dc.COMPRA')
            ->join('PRODUCTO as p', 'dc.PRODUCTO', '=', 'p.ID')
            ->leftJoin('users as u', 'c.USUARIO', '=', 'u.id')
            ->select(
                DB::raw("'Compra' as tipo_movimiento"),
                'c.created_at as fecha_movimiento',
                'c.TOTAL as total_mov',
                'p.CODIGO as codigo_producto',
                'p.NOMBRE as nombre_producto',
                'dc.PRECIO as precio_unitario',
                'dc.CANTIDAD as cantidad',
                DB::raw('(dc.CANTIDAD * dc.PRECIO) as subtotal'),
                'u.nombre as nombre_usuario'
            )
            ->when($this->fecha_inicio, fn($q) => $q->whereDate('c.created_at', '>=', $this->fecha_inicio))
            ->when($this->fecha_fin, fn($q) => $q->whereDate('c.created_at', '<=', $this->fecha_fin))
            ->when($this->producto_id, fn($q) => $q->where('p.ID', $this->producto_id))
            ->when($this->tipo, fn($q) => $q->where('tipo_movimiento', '=', $this->tipo))
            ->orderBy('fecha_movimiento', 'desc');


        // Combinar los movimientos con UNION
        return $compras->unionAll($ventas)
            //->when($this->tipo, fn($q) => $q->where('tipo_movimiento','=', $this->tipo))
            ->orderBy('fecha_movimiento', 'desc');
    }



    public function render()
    {
        $lista = $this->queryBase()->paginate($this->perPage);
        $this->total_mov = collect($lista->items())->sum('subtotal');
        $this->cantidad_mov = collect($lista->items())->sum('cantidad');

        return view('livewire.control.historial-movimientos', [
            'lista' => $lista,
            'total' => $this->total_mov,
            'cantidad' => $this->cantidad_mov,
        ]);
    }

    public function exportarPDF()
    {
        $ventas = $this->queryBase()->get();
        $this->total_ventas = $ventas->sum('subtotal');
        $this->total_cantidad = $ventas->sum('cantidad');
        $productos = Producto::where('ESTADO', 1)->get();

        $pdf = Pdf::loadView('reportes.historial-movimientos-pdf', [
            'ventas' => $ventas,
            'total_ventas' => $this->total_ventas,
            'total_cantidad' => $this->total_cantidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'productos' => $productos,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'historial_movimientos_' . now()->format('Ymd_His') . '.pdf');
    }

    public function exportarHTML()
    {
        $ventas = $this->queryBase()->get();
        $this->total_ventas = $ventas->sum('subtotal');
        $this->total_cantidad = $ventas->sum('cantidad');
        $productos = Producto::where('ESTADO', 1)->get();

        // Renderizas la vista directamente (no con Pdf::loadView)
        $html = view('reportes.html.historial-movimiento', [
            'ventas' => $ventas,
            'total_ventas' => $this->total_ventas,
            'total_cantidad' => $this->total_cantidad,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'productos' => $productos,
        ])->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'historial_movimientos.html', [
            'Content-Type' => 'text/html',
        ]);

    }





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



    public function exportarExcel()
    {
        $ventas = $this->queryBase()->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Historial de Movimientos');

        // Encabezados
        $sheet->fromArray([
            'Fecha',
            'Tipo',
            'Código',
            'Producto',
            'Cantidad',
            'Subtotal',
            'Usuario'
        ], null, 'A1');

        // Cuerpo
        $row = 2;
        foreach ($ventas as $venta) {
            $sheet->fromArray([
                \Carbon\Carbon::parse($venta->fecha_movimiento)->format('d/m/Y H:i'),
                $venta->tipo_movimiento,
                $venta->codigo_producto,
                $venta->nombre_producto,
                $venta->cantidad,
                $venta->subtotal,
                $venta->nombre_usuario ?? 'N/A'
            ], null, 'A' . $row);
            $row++;
        }

        // Descargar
        $filename = 'historial_movimientos_' . now()->format('Ymd_His') . '.xlsx';
        $path = storage_path('app/public/' . $filename);

        $writer = new Xlsx($spreadsheet);
        $writer->save($path);

        return response()->download($path)->deleteFileAfterSend(true);
    }

}