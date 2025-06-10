<?php

namespace App\Livewire\Productos;

use Livewire\Component;
use App\Models\Producto;
use Carbon\Carbon;

class ReporteSinStock extends Component
{
    public $productos;

    public function mount()
    {
        $this->productos = Producto::where('CANTIDAD', '<=', 0)
            ->with(['detalleVenta.venta'])
            ->get()
            ->map(function ($producto) {
                $ultimaVenta = $producto->detalleVenta
                    ->filter(fn($dv) => $dv->venta !== null)
                    ->sortByDesc(fn($dv) => $dv->venta->created_at)
                    ->first();

                $producto->fecha_ultima_venta = $ultimaVenta
                    ? Carbon::parse($ultimaVenta->venta->created_at)->format('d/m/Y H:i')
                    : 'Sin ventas';

                $producto->id_ultima_venta = $ultimaVenta && $ultimaVenta->venta
                    ? $ultimaVenta->venta->id // o 'id' según tu tabla
                    : '-';

                return $producto;
            });
    }

    public function render()
    {
        return view('livewire.productos.reporte-sin-stock', [
            'productos' => $this->productos,
        ]);
    }
}
