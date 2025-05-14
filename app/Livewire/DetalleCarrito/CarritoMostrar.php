<?php

namespace App\Livewire\DetalleCarrito;

use Livewire\Component;
use App\Models\Carrito;
use App\Models\DetalleCarrito;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
class CarritoMostrar extends Component
{
    use WithPagination;
    public $idcarrito = '', $cliente = '', $metodo_pago, $estado;
    public $fecha_inicio, $fecha_fin;
    public $perPage = 5;
    public $carrito_parm;
    public function render()
    {
        $carrito = $this->obtenerCarrito();
        return view('livewire.detalle-carrito.carrito-mostrar', compact('carrito'));
    }
    public function verDetalleCarrito($idcarrito)
    {
        $this->carrito_parm = $idcarrito;
    }

    public function obtenerCarrito()
    {
        return Carrito::query()
            ->join('users as cliente', 'cliente.id', '=', 'CARRITO.CLIENTE')
            ->select(
                'CARRITO.*',
                DB::raw("cliente.nombre as cliente_nombre"),
                DB::raw("cliente.paterno as cliente_paterno"),
                DB::raw("cliente.materno as cliente_materno")
            )
            ->where(function ($query) {
                $query->when(
                    $this->idcarrito,
                    fn($q) => $q->where('CARRITO.ID', 'like', '%' . $this->idcarrito . '%')
                )
                    ->when(
                        $this->cliente,
                        fn($q) => $q->where(
                            DB::raw("cliente.nombre || ' ' || cliente.paterno || ' ' || cliente.materno"),
                            'like',
                            '%' . $this->cliente . '%'
                        )
                    )
                    ->when(
                        $this->metodo_pago,
                        fn($q) => $q->where('CARRITO.METODO_PAGO', 'like', '%' . $this->metodo_pago . '%')
                    )
                    ->when(
                        $this->fecha_inicio,
                        fn($q) => $q->whereDate('CARRITO.created_at', '>=', $this->fecha_inicio)
                    )
                    ->when(
                        $this->fecha_fin,
                        fn($q) => $q->whereDate('CARRITO.created_at', '<=', $this->fecha_fin)
                    )
                    ->when(
                        $this->estado !== null && $this->estado !== '',
                        function ($q) {
                            $estadoBool = $this->estado == '1' ? true : false;
                            $q->where('CARRITO.ESTADO', '=', $estadoBool);
                        }
                    );
            })
            ->orderBy('CARRITO.created_at', 'desc')
            ->paginate($this->perPage);
    }
    public function editarEstado($id)
    {
        $carrito = Carrito::find($id);
        if ($carrito) {
            $carrito->ESTADO = $carrito->ESTADO == 1 ? 0 : 1; // Cambia el estado
            $carrito->save(); // Reinicia la paginación
            session()->flash('message', 'Estado actualizado correctamente.');
        } else {
            session()->flash('error', 'Carrito no encontrada.');
        }
    }
}
