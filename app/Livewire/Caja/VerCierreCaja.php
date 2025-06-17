<?php

namespace App\Livewire\Caja;

use Livewire\Component;
use App\Models\Venta;
use App\Models\CajaPagos;
use App\Models\Gasto;
use App\Models\Caja;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\DB;

class VerCierreCaja extends Component
{
    public $id_caja;
    public $caja;
    public $pagos, $ventas, $compras, $metodo_pago;
    public $descripcion;
    public $montos = [];

    public $pagosAgrupados = [];
    public $ventasAgrupadas = [];
    public $comprasAgrupadas = [];

    public $diferenciasPorMetodo = [];

    public function mount($id_caja)
    {
        $this->id_caja = $id_caja;
        $this->metodo_pago = MetodoPago::all();
        $this->loadDatosCaja($id_caja);
    }

    public function updatedIdCaja($value)
    {
        $this->loadDatosCaja($value);
    }

    public function loadDatosCaja($id)
    {
        $this->pagos = CajaPagos::where('CAJA', $id)->get();
        $this->ventas = Venta::where('CAJA', $id)->get();
        $this->compras = Gasto::where('CAJA', $id)->get();

        // Montos para edición
        $this->montos = [];
        foreach ($this->pagos as $pago) {
            $this->montos[$pago->METODO_PAGO] = $pago->MONTO;
        }

        // Agrupación
        $this->pagosAgrupados = $this->pagos
            ->groupBy('METODO_PAGO')
            ->map(fn($items) => [
                'metodo' => $items->first()->METODO_PAGO,
                'monto' => $items->sum('MONTO'),
            ])->values()->toArray();

        $this->ventasAgrupadas = $this->ventas
            ->groupBy('METODO_PAGO')
            ->map(fn($items) => [
                'metodo' => $items->first()->METODO_PAGO,
                'monto' => $items->sum('TOTAL'),
            ])->values()->toArray();

        $this->comprasAgrupadas = $this->compras
            ->groupBy('METODO_PAGO')
            ->map(fn($items) => [
                'metodo' => $items->first()->METODO_PAGO,
                'monto' => $items->sum('MONTO'),
            ])->values()->toArray();

        // Comparación declarados vs cobrados
        $this->diferenciasPorMetodo = [];
        $metodos = collect($this->metodo_pago)->pluck('METODO_PAGO');

        foreach ($metodos as $metodo) {
            $declarado = collect($this->pagosAgrupados)->firstWhere('metodo', $metodo)['monto'] ?? 0;
            $cobrado = collect($this->ventasAgrupadas)->firstWhere('metodo', $metodo)['monto'] ?? 0;

            $this->diferenciasPorMetodo[] = [
                'metodo' => $metodo,
                'declarado' => $declarado,
                'cobrado' => $cobrado,
                'diferencia' => $declarado - $cobrado,
            ];
        }
    }

    public function registrarCierre()
    {
        if (!auth()->id()) {
            session()->flash('error', 'Debes iniciar sesión para registrar un cierre.');
            return;
        }

        $montosFiltrados = collect($this->montos)
            ->filter(fn($monto) => is_numeric($monto) && $monto >= 0)
            ->filter(fn($monto, $metodoPago) => !empty($metodoPago))
            ->toArray();

        if (empty($montosFiltrados)) {
            session()->flash('message', 'Debes ingresar al menos un monto válido.');
            return;
        }

        $totalDeclarado = array_sum($montosFiltrados);
        $ventasReales = Venta::where('CAJA', $this->id_caja)->sum('total');
        $diferencia = $ventasReales - $totalDeclarado;
        $estado = $diferencia <= 0;

        $caja = Caja::findOrFail($this->id_caja);

        $caja->update([
            'DESCRIPCION' => $this->descripcion ?? $caja->DESCRIPCION,
            'ESTADO' => $estado,
        ]);

        $metodosPagoValidos = MetodoPago::pluck('METODO_PAGO')->toArray();

        foreach ($montosFiltrados as $metodoPago => $monto) {
            if (empty($caja->ID) || empty($metodoPago)) {
                continue; // Evita errores por valores vacíos
            }

            if (!in_array($metodoPago, $metodosPagoValidos)) {
                session()->flash('error', "El método de pago '{$metodoPago}' no es válido.");
                continue;
            }

            CajaPagos::updateOrCreate(
                ['CAJA' => $caja->ID, 'METODO_PAGO' => $metodoPago],
                ['MONTO' => $monto, 'updated_at' => now()]
            );
        }

        session()->flash('message', 'Cierre de caja actualizado correctamente.');
        $this->loadDatosCaja($this->id_caja);
    }


    public function render()
    {
        return view('livewire.caja.ver-cierre-caja');
    }
}
