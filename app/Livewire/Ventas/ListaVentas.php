<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListaVentas extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $idventa = '', $cliente = '', $vendedor = '', $metodo_pago, $estado;
    public $fecha_inicio, $fecha_fin;
    protected $listeners = ['enviarMetodoPagoVentas' => 'recibirMetodoPago'];

    public $venta_parm;


    public function render()
    {// Llamamos a la función para obtener los usuarios

        $ventas = $this->obtenerVentas();

        // Usamos DB para obtener los roles (o puedes definir un modelo para roles)
        //  $roles = DB::table('ROL')->pluck('ROL');

        return view('livewire.ventas.lista-ventas', compact('ventas'))
            ->extends('layouts.app')
            ->section('content');
    }
    public function obtenerVentas()
    {
        $this->buscarDatos();
        return Venta::query()
            ->join('users as cliente', 'VENTA.CLIENTE', '=', 'cliente.id')
            ->join('users as usuario', 'VENTA.usuario', '=', 'usuario.id')
            ->select(
                'VENTA.*',
                DB::raw("cliente.nombre as cliente_nombre"),
                DB::raw("cliente.paterno as cliente_paterno"),
                DB::raw("cliente.materno as cliente_materno"),
                DB::raw("usuario.nombre as usuario_nombre")
            )
            ->where(function ($query) {
                $query->when(
                    $this->idventa,
                    fn($q) =>
                    $q->where('VENTA.id', 'like', '%' . $this->idventa . '%')
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
                        $q->where('VENTA.metodo_pago', 'like', '%' . $this->metodo_pago . '%')
                    )
                    ->when(
                        $this->fecha_inicio,
                        fn($q) =>
                        $q->whereDate('VENTA.created_at', '>=', $this->fecha_inicio)
                    )
                    ->when(
                        $this->fecha_fin,
                        fn($q) =>
                        $q->whereDate('VENTA.created_at', '<=', $this->fecha_fin)
                    )->when($this->estado !== null && $this->estado !== '', function ($q) {
                        $estadoBool = $this->estado == '1' ? true : false;
                        $q->where('VENTA.estado', '=', $estadoBool);
                    });

            })
            ->orderBy('VENTA.id', 'desc')
            ->paginate($this->perPage);

    }

    public function verDetalle($idventa)
    {
        $this->venta_parm = $idventa;
    }

    public function exportarPdf()
    {
        $query = http_build_query([
            'idventa' => $this->idventa,
            'cliente' => $this->cliente,
            'vendedor' => $this->vendedor,
            'metodo_pago' => $this->metodo_pago,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
            'estado' => $this->estado,
        ]);

        return redirect()->to(route('ventas.exportar-pdf') . '?' . $query);
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
        $VENTA = Venta::find($id);
        if ($VENTA) {
            $VENTA->ESTADO = $VENTA->ESTADO == 1 ? 0 : 1; // Cambia el estado
            $VENTA->save(); // Reinicia la paginación
            session()->flash('message', 'Estado actualizado correctamente.');
        } else {
            session()->flash('error', 'Venta no encontrada.');
        }
    }
}
