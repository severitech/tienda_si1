<?php

namespace App\Livewire\DetalleCompra;

use Livewire\Component;
use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class ListaDetalleCompra extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $idcompra = '', $proveedor = '', $usuario = '', $metodo_pago, $estado;
    public $fecha_inicio, $fecha_fin;
    protected $listeners = ['enviarMetodoPagoVentas' => 'recibirMetodoPago'];

    public $param_compra;


    public function obtenerVentas()
    {
        return Compra::query()
        ->join('PROVEEDOR', 'COMPRA.PROVEEDOR', '=', 'PROVEEDOR.ID')
        ->join('users as usuario', 'COMPRA.USUARIO', '=', 'usuario.id')
        ->select(
            'COMPRA.*',
            DB::raw("usuario.nombre as cliente_nombre"),
            DB::raw("usuario.paterno as cliente_paterno"),
            DB::raw("usuario.materno as cliente_materno")
        )
        ->where(function ($query) {
            $query->when($this->idcompra, function ($q) {
                $q->where('COMPRA.ID', 'like', '%' . $this->idcompra . '%');
            });

            $query->when($this->proveedor, function ($q) {
                $q->where('COMPRA.PROVEEDOR', 'like', '%' . $this->proveedor . '%');
            });

            $query->when($this->usuario, function ($q) {
                // Concatenar nombre completo (nota: esta parte depende del motor SQL, para MySQL usar CONCAT_WS)
                $q->where(
                    DB::raw("CONCAT(usuario.nombre, ' ', usuario.paterno, ' ', usuario.materno)"),
                    'like',
                    '%' . $this->usuario . '%'
                );
            });

            $query->when($this->metodo_pago, function ($q) {
                $q->where('COMPRA.METODO_PAGO', 'like', '%' . $this->metodo_pago . '%');
            });

            $query->when($this->fecha_inicio, function ($q) {
                $q->whereDate('COMPRA.created_at', '>=', $this->fecha_inicio);
            });

            $query->when($this->fecha_fin, function ($q) {
                $q->whereDate('COMPRA.created_at', '<=', $this->fecha_fin);
            });

            $query->when($this->estado !== null && $this->estado !== '', function ($q) {
                $estadoBool = $this->estado == '1' ? true : false;
                $q->where('COMPRA.ESTADO', '=', $estadoBool);
            });
        })
        ->orderBy('COMPRA.ID', 'desc')
        ->paginate($this->perPage);

    }

    public function verDetalle($idcompra)
    {
        $this->param_compra = $idcompra;
    }
    public $mensaje = '';
    public function mount()
    {
        $this->fecha_fin = now()->format('Y-m-d');
        $this->fecha_inicio = now()->format('Y-m-d');

    }
    public function buscarDatos()
    {
        $this->mensaje = 'idcompra: ' . $this->idcompra .
            ' cliente: ' . $this->cliente .
            ' vendedor: ' . $this->vendedor .
            ' metodo_pago: ' . $this->metodo_pago .
            ' fecha_inicio: ' . $this->fecha_inicio .
            ' fecha_fin: ' . $this->fecha_fin . ' Estado: ' . $this->estado;
    }
    public function recibirMetodoPago($metodoSeleccionado)
    {
        $this->metodo_pago = $metodoSeleccionado;
    }
    public function actualizarEstado($estado)
    {
        $this->estado = $estado;
    }

    public function updatedEstado()
    {
        $this->resetPage(); // Reinicia la paginación
    }
    public function editarEstado($id)
    {
        $venta = Compra::find($id);
        if ($venta) {
            $venta->ESTADO = $venta->ESTADO == 1 ? 0 : 1; // Cambia el estado
            $venta->save(); // Reinicia la paginación
            session()->flash('message', 'Estado actualizado correctamente.');
        } else {
            session()->flash('error', 'Venta no encontrada.');
        }
    }
    public function render()
    {
        $compra = $this->obtenerVentas();
        $proveedores = Proveedor::all();
        return view('livewire.detalle-compra.lista-detalle-compra', compact('compra', 'proveedores'));
    }
}
