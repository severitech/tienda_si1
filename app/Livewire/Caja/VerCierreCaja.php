<?php

namespace App\Livewire\Caja;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Gasto;
use App\Models\Caja;
use App\Models\MetodoPago;
use Illuminate\Support\Facades\DB;

class VerCierreCaja extends Component
{
    public $id_caja;
    public $descripcion;
    public $metodo_pago;

    public $pagos, $ventas, $compras, $montos = [];
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
        $this->pagos = DB::table('CAJA_PAGO')->where('CAJA', $id)->get();

        if ($this->pagos->isEmpty()) {
            $this->ventas = collect();
            $this->compras = collect();
            $this->montos = [];
            $this->pagosAgrupados = [];
            $this->ventasAgrupadas = [];
            $this->comprasAgrupadas = [];
            $this->diferenciasPorMetodo = [];

            session()->flash('error', 'No se encontraron pagos para esta caja. Probablemente no se haya creado el registro.');
            return;
        }

        $this->ventas = Venta::where('CAJA', $id)->where('ESTADO', '!=', 0)->get();
        $this->compras = Gasto::where('CAJA', $id)->where('ESTADO', '!=', 0)->get();

        $this->montos = [];
        foreach ($this->pagos as $p) {
            $this->montos[$p->METODO_PAGO] = $p->MONTO;
        }

        $this->pagosAgrupados = collect($this->pagos)
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

        $this->diferenciasPorMetodo = [];
        $metodos = $this->metodo_pago->pluck('METODO_PAGO');

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

        $caja = Caja::find($this->id_caja);
        if (!$caja) {
            session()->flash('error', 'No se encontró la caja seleccionada.');
            return;
        }

        $montos = collect($this->montos)
            ->filter(fn($m) => is_numeric($m) && $m >= 0)
            ->filter(fn($m, $mt) => !empty($mt))
            ->toArray();

        if (empty($montos)) {
            session()->flash('error', 'Debes ingresar al menos un monto válido.');
            return;
        }

        $ventasReales = Venta::where('CAJA', $this->id_caja)->sum('TOTAL');

        // Insertar/actualizar/eliminar pagos
        $metodosValidos = MetodoPago::pluck('METODO_PAGO')->toArray();

        foreach ($montos as $metodoPago => $monto) {
            if (!in_array($metodoPago, $metodosValidos)) {
                session()->flash('error', "Método de pago no válido: {$metodoPago}");
                continue;
            }

            $pagoExistente = DB::table('CAJA_PAGO')
                ->where('CAJA', $this->id_caja)
                ->where('METODO_PAGO', $metodoPago)
                ->first();

            if ($monto == 0) {
                if ($pagoExistente) {
                    DB::table('CAJA_PAGO')
                        ->where('CAJA', $this->id_caja)
                        ->where('METODO_PAGO', $metodoPago)
                        ->delete();
                }
                continue;
            }

            if ($pagoExistente) {
                DB::table('CAJA_PAGO')
                    ->where('CAJA', $this->id_caja)
                    ->where('METODO_PAGO', $metodoPago)
                    ->update(['MONTO' => $monto]);
            } else {
                DB::table('CAJA_PAGO')->insert([
                    'CAJA' => $this->id_caja,
                    'METODO_PAGO' => $metodoPago,
                    'MONTO' => $monto,
                ]);
            }
        }

        // Recalcular totales declarados después de guardar
        $totalDeclarado = DB::table('CAJA_PAGO')
            ->where('CAJA', $this->id_caja)
            ->sum('MONTO');

        $diferencia = $ventasReales - $totalDeclarado;
        $estado = $diferencia <= 0;

        $caja->update([
            'DESCRIPCION' => $this->descripcion ?: $caja->DESCRIPCION,
            'ESTADO' => $estado,
            'DECLARADO' => $totalDeclarado,     // Total declarado
            'DIFERENCIA' => $diferencia,     // Diferencia ventas vs declarado
        ]);

        session()->flash('message', 'Cierre de caja actualizado correctamente.');
        $this->loadDatosCaja($this->id_caja);
    }




    public function render()
    {
        return view('livewire.caja.ver-cierre-caja');
    }
}
