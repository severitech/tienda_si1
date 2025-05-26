<?php

namespace App\Livewire\DetalleCompra;

use Livewire\Component;
use App\Model\Compra;

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
        $this->buscarDatos();
        return Compra::query()
            ->join('proveedor', 'compra.id_proveedor', '=', 'proveedor.id')
            ->join('users as usuario', 'venta.usuario', '=', 'usuario.id')
            ->select(
                'venta.*',
                DB::raw("cliente.nombre as cliente_nombre"),
                DB::raw("cliente.paterno as cliente_paterno"),
                DB::raw("cliente.materno as cliente_materno"),
                DB::raw("usuario.nombre as usuario_nombre")
            )
            ->where(function ($query) {
                $query->when(
                    $this->idventa,
                    fn($q) =>
                    $q->where('venta.id', 'like', '%' . $this->idventa . '%')
                )
                    ->when(
                        $this->cliente,
                        fn($q) =>
                        $q->where(DB::raw("cliente.nombre || ' ' || cliente.paterno || ' ' || cliente.materno"), 'like', '%' . $this->cliente . '%')
                    )
                    ->when(
                        $this->vendedor,
                        fn($q) =>
                        $q->where(DB::raw("usuario.nombre || ' ' || usuario.paterno || ' ' || usuario.materno"), 'like', '%' . $this->vendedor . '%')
                    )
                    ->when(
                        $this->metodo_pago,
                        fn($q) =>
                        $q->where('venta.metodo_pago', 'like', '%' . $this->metodo_pago . '%')
                    )
                    ->when(
                        $this->fecha_inicio,
                        fn($q) =>
                        $q->whereDate('venta.created_at', '>=', $this->fecha_inicio)
                    )
                    ->when(
                        $this->fecha_fin,
                        fn($q) =>
                        $q->whereDate('venta.created_at', '<=', $this->fecha_fin)
                    )->when($this->estado !== null && $this->estado !== '', function ($q) {
                        $estadoBool = $this->estado == '1' ? true : false;
                        $q->where('venta.estado', '=', $estadoBool);
                    });

            })
            ->orderBy('venta.id', 'desc')
            ->paginate($this->perPage);

    }

    public function verDetalle($idventa)
    {
        $this->venta_parm = $idventa;
    }
    public $mensaje = '';
    public function mount()
    {
        $this->fecha_fin = now()->format('Y-m-d');
        $this->fecha_inicio = now()->format('Y-m-d');

    }
    public function buscarDatos()
    {
        $this->mensaje = 'idventa: ' . $this->idventa .
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
        $venta = Venta::find($id);
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
        return view('livewire.detalle-compra.lista-detalle-compra');
    }
}
