<?php
namespace App\Livewire\Caja;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Gasto;
use App\Models\Compra;
use App\Models\Caja;
use Illuminate\Support\Facades\DB;

class ArqueoCaja extends Component
{
    public $totalVentas = 0;
    public $totalGastos = 0;
    public $totalCompras = 0;
    public $totalEgresos = 0;
    public $totalIngresos = 0;
    public $saldo = 0;
    public $detalleMetodosPago = [];
    public $id_caja = null;


    public function mount()
    {
        $this->totalVentas = Venta::sum('total');
        $this->totalGastos = Gasto::select(DB::raw('SUM(monto * cantidad) as total'))->value('total');
        $this->totalCompras = Compra::sum('total');

        $this->totalIngresos = $this->totalVentas;
        $this->totalEgresos = $this->totalGastos + $this->totalCompras;
        $this->saldo = $this->totalIngresos - $this->totalEgresos;

        $this->detalleMetodosPago = DB::table('CAJA_PAGO')
            ->select('METODO_PAGO', DB::raw('SUM(MONTO) as total'))
            ->groupBy('METODO_PAGO')
            ->get();
    }

    public function obtenerCaja()
    {
        return Caja::with('usuario')->orderBy('id', 'desc')->get();
    }

    public function render()
    {
        $caja = $this->obtenerCaja();
        return view('livewire.caja.arqueo-caja', compact('caja'));
    }
    public function actualizarCierre($id)
    {
        $this->id_caja = $id;
        // dd($this->id_caja);
    }
}
