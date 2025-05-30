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

    public function mount($id_caja)
    {
        $this->id_caja = $id_caja;

        $this->metodo_pago = MetodoPago::all();
        $this->pagos = CajaPagos::where('CAJA', $id_caja)->get();
        $this->ventas = Venta::where('CAJA', $id_caja)->get();
        $this->compras = Gasto::where('CAJA', $id_caja)->get();

        // Llenar montos[] con los valores de CajaPagos
        foreach ($this->pagos as $pago) {
            $this->montos[$pago->METODO_PAGO] = $pago->MONTO;
        }
    }

    public function render()
    {
        return view('livewire.caja.ver-cierre-caja');
    }

    public function registrarCierre()
    {
        if (!auth()->id()) {
            session()->flash('error', 'Debes iniciar sesión para registrar un cierre.');
            return;
        }

        $montosFiltrados = collect($this->montos)
            ->filter(fn($monto) => is_numeric($monto) && $monto >= 0)
            ->filter(fn($monto, $metodoPago) => !empty($metodoPago)) // Evita keys vacías
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
            if (!in_array($metodoPago, $metodosPagoValidos)) {
                session()->flash('error', "El método de pago '{$metodoPago}' no es válido.");
                continue;
            }

            DB::table('CAJA_PAGO')->updateOrInsert(
                ['CAJA' => $caja->ID, 'METODO_PAGO' => $metodoPago],
                ['MONTO' => $monto, 'updated_at' => now()]
            );
        }

        session()->flash('message', 'Cierre de caja actualizado correctamente.');
    }


}
