<?php
namespace App\Livewire\Caja;

use Livewire\Component;
use App\Models\Venta;
use App\Models\Gasto;
use App\Models\Compra;
use App\Models\Caja;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class ArqueoCaja extends Component
{
    use WithPagination;

    public $id_caja = null;

    public $usuario_id = null, $fecha_inicio, $fecha_fin;
    public $perPage = 5;

    public function mount()
    {

        $hoy = now()->format('Y-m-d');
        $this->fecha_inicio = $hoy;
        $this->fecha_fin = $hoy;

    }


    public function obtenerCaja()
    {
        return Caja::with('usuario')
            ->when($this->fecha_inicio, function ($query) {
                $query->whereDate('created_at', '>=', $this->fecha_inicio);
            })
            ->when($this->fecha_fin, function ($query) {
                $query->whereDate('created_at', '<=', $this->fecha_fin);
            })
            ->when($this->usuario_id, function ($query) {
                $query->where('USUARIO', $this->usuario_id);
            })
            ->orderBy('id', 'desc')
            ->paginate($this->perPage);
        ;

    }

    public function exportarPDF()
    {
        $caja = $this->obtenerCaja();
        $venta = Venta::where('CAJA', $caja->id)
            ->where('ESTADO', '!=', 'ANULADO')->sum('TOTAL')
            ->get();

    }
    public function render()
    {
        $caja = $this->obtenerCaja();
        $usuarios = User::
            all();
        return view('livewire.caja.arqueo-caja', compact('caja', 'usuarios'));
    }
    public function actualizarCierre($id)
    {
        $this->id_caja = $id;
    }

    public function exportar($formato)
    {
        return redirect()->route('exportar.caja', [
            'formato' => $formato,
            'inicio' => $this->fecha_inicio,
            'fin' => $this->fecha_fin,
            'usuario' => $this->usuario_id,
        ]);
    }

}
