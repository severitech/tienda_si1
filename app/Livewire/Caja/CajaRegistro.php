<?php

namespace App\Livewire\Caja;

use App\Models\Caja;
use App\Models\MetodoPago;
use Livewire\Component;
use App\Models\Venta;
use App\Models\Gasto;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CajaRegistro extends Component
{

    public $montos = [];
    public $descripcion, $totalPagos = 0;
    public $totalVenta = 0, $totalGasto = 0, $totalCompra = 0;
    public function render()
    {
        $metodo_pago = MetodoPago::all();
        return view('livewire.caja.caja-registro', compact('metodo_pago'));
    }
    public function mount()
    {
        $this->totalVenta = $this->obtenerTotalVentas();
        $this->totalGasto = $this->obtenerTotalGasto();
        $this->totalCompra = $this->obtenerTotalCompra();
    }
    public function obtenerTotalVentas()
    {
        return Venta::whereNull('caja')->sum('total');
    }

    public function obtenerTotalGasto()
    {
        return Gasto::whereNull('caja')
            ->select(DB::raw('SUM(monto * cantidad) as total'))
            ->value('total');
    }
    public function obtenerTotalCompra()
    {
        return Compra::whereNull('caja')->sum('total');
    }
    public function registrarCierre()
    {
        if (!auth()->id()) {
            session()->flash('error', 'Debes iniciar sesión para registrar un cierre.');
            return;
        }

        // Validar montos válidos
        $montosFiltrados = collect($this->montos)
            ->filter(fn($monto) => is_numeric($monto) && $monto > 0)
            ->toArray();

        if (empty($montosFiltrados)) {
            session()->flash('message', 'Debes ingresar al menos un monto válido.');
            return;
        }

        // Calcular total declarado por el usuario
        $totalDeclarado = array_sum($montosFiltrados);

        // Calcular total real de ventas sin caja (cierre real)
        $ventasReales = Venta::whereNull('caja')->sum('total');

        // Calcular diferencia
        $diferencia =  round($totalDeclarado -$ventasReales,2);

     

        // Crear cierre de caja con todos los atributos
        $caja = Caja::create([
            'DESCRIPCION' => $this->descripcion,
            'DECLARADO' => $totalDeclarado,
            'CIERRE' => $ventasReales,
            'DIFERENCIA' => $diferencia,
            'USUARIO' => auth()->id(),
        ]);

        // Validar metodos de pago
        $metodosPagoValidos = MetodoPago::pluck('METODO_PAGO')->toArray();

        foreach ($montosFiltrados as $metodoPago => $monto) {
            if (!in_array($metodoPago, $metodosPagoValidos)) {
                session()->flash('error', "El método de pago '{$metodoPago}' no es válido.");
                continue;
            }

            DB::table('CAJA_PAGO')->insert([
                'CAJA' => $caja->ID,
                'METODO_PAGO' => $metodoPago,
                'MONTO' => $monto,
            ]);
        }

        // Asignar caja a ventas, compras y gastos que aun no la tienen
        Venta::whereNull('caja')->update(['caja' => $caja->ID]);
        Compra::whereNull('caja')->update(['caja' => $caja->ID]);
        Gasto::whereNull('caja')->update(['caja' => $caja->ID]);

        $this->reset(['descripcion', 'montos']);
        session()->flash('message', 'Cierre guardado con éxito.');
        $this->mount();
    }

}
