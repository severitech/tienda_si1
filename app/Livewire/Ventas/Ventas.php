<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\User;
class Ventas extends Component
{
    use WithPagination;
    public $cliente_id;
    public $productosSeleccionados = [];
    public $metodoPago = '';
    public $totalVenta = 0;
    public $metodoPagoSeleccionado;
    protected $listeners = [
        'clienteSeleccionado' => 'asignarCliente'
        ,
        'enviarProducto' => 'recibirProducto',
        'enviarMetodoPagoVentas' => 'recibirMetodoPago'
        ,
    ];


    public function recibirMetodoPago($metodoPago)
    {
        $this->metodoPagoSeleccionado = $metodoPago;
    }

    public function render()
    {
        return view('livewire.ventas.ventas');
    }
    public function asignarCliente($id)
    {
        $this->cliente_id = $id;
    }
    public function mostrarvalores()
    {
        // session()->flash('message',"Mensaje". $this->cliente_id);
        session()->flash('message', 'Producto(s) agregados: ' . implode(', ', array_column($this->productosSeleccionados, 'nombre' . ' ' . 'cantidad' . ' ' . 'precio')));
    }

    public function productoSeleccionado($productos)
    {
        $this->productosSeleccionados = $productos;
    }

    public function recibirProducto($productoData)
    {
        $producto = Producto::find($productoData['id']);
        if ($producto) {
            $existente = collect($this->productosSeleccionados)->firstWhere('id', $productoData['id']);

            if ($existente) {
                foreach ($this->productosSeleccionados as &$item) {
                    if ($item['id'] === $productoData['id']) {
                        $item['cantidad'] += $productoData['cantidad'];
                        $item['subtotal'] = $item['cantidad'] * $productoData['precio'];
                        break;
                    }
                }
            } else {
                // Si no existe, agregar nuevo producto
                $this->productosSeleccionados[] = [
                    'id' => $productoData['id'],
                    'nombre' => $producto->NOMBRE,
                    'precio' => $productoData['precio'],
                    'cantidad' => $productoData['cantidad'],
                    'subtotal' => $productoData['subtotal'],
                ];
            }

            //  session()->flash('valor', 'Producto agregado: ' . $producto->NOMBRE . ' x' . $productoData['cantidad'] . ' @' . $productoData['precio']);
            // Recalcular el total de la venta
            $this->totalVenta = array_sum(array_column($this->productosSeleccionados, 'subtotal'));

        } else {
            session()->flash('message', 'Producto no encontrado.');
        }
    }

    public function eliminar($id)
    {
        $this->productosSeleccionados = array_filter($this->productosSeleccionados, function ($producto) use ($id) {
            return $producto['id'] !== $id;
        });

        $this->totalVenta = array_sum(array_column($this->productosSeleccionados, 'subtotal'));
    }


    public function registrarVenta()
    {
        // Validaciones previas
        if (!$this->cliente_id) {
            session()->flash('message', 'Por favor, selecciona un cliente.');
            return;
        }

        if (empty($this->productosSeleccionados)) {
            session()->flash('message', 'Por favor, selecciona al menos un producto.');
            return;
        }

        if (empty($this->metodoPagoSeleccionado)) {
            session()->flash('message', 'Por favor, selecciona un método de pago.');
            return;
        }

        // Guardar la venta
        $venta = new Venta();
        $venta->CLIENTE = $this->cliente_id;
        $venta->METODO_PAGO = $this->metodoPagoSeleccionado;
        $venta->TOTAL = $this->totalVenta;
        $venta->USUARIO = auth()->id();
        $venta->save();

        foreach ($this->productosSeleccionados as $producto) {
            DB::table('DETALLE_VENTA')->insert([
                'VENTA' => $venta->id,
                'PRODUCTO' => $producto['id'],
                'PRECIO' => $producto['precio'],
                'CANTIDAD' => $producto['cantidad'],

            ]);

            // Descontar stock
            // $productoModel = Producto::find($producto['id']);
            // if ($productoModel) {
            //     $productoModel->CANTIDAD -= $producto['cantidad'];
            //     $productoModel->save();
            // }
        }

        $this->reset([
            'cliente_id',
            'productosSeleccionados',
            'metodoPagoSeleccionado',
            'totalVenta',
        ]);
        //limpiar metodo de pago y nombre del cliente en el input
        $this->dispatch('limpiar');

        session()->flash('message', 'Venta registrada correctamente.');
    }

}
