<?php

namespace App\Livewire\Compra;

use Livewire\Component;
use App\Models\Producto;
use App\Models\Compra;
use Illuminate\Support\Facades\DB;


class CompraProductos extends Component
{
    public $proveedor_id;
    public $productosSeleccionados = [];
    public $metodoPago = '';
    public $totalVenta = 0;
    public $totalProductos = 0;
    public $metodoPagoSeleccionado;
    protected $listeners = [
        'proveedorSeleccionadoCompra' => 'recibirProveedor'
        ,
        'enviarProductoCompra' => 'recibirProducto',
        'enviarMetodoPagoVentas' => 'recibirMetodoPago'
        ,
    ];
    public function render()
    {
        return view('livewire.compra.compra-productos');
    }

    public function recibirMetodoPago($metodoPago)
    {
        $this->metodoPagoSeleccionado = $metodoPago;
    }
    public function recibirProveedor($id)
    {
        $this->proveedor_id = $id;
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
                    $item['subtotal'] = $item['cantidad'] * $item['precio']; // ✅ corrección aquí
                    break;
                }
            }
        } else {
            $this->productosSeleccionados[] = [
                'id' => $productoData['id'],
                'nombre' => $producto->NOMBRE,
                'precio' => $productoData['precio'],
                'cantidad' => $productoData['cantidad'],
                'subtotal' => $productoData['subtotal'],
            ];
        }

        // Recalcular total
        $this->totalVenta = array_sum(array_column($this->productosSeleccionados, 'subtotal'));
        $this->totalProductos = array_sum(array_column($this->productosSeleccionados, 'cantidad'));

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
        if (!$this->proveedor_id) {
            session()->flash('message', 'Por favor, selecciona un Proveedor.');
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
        $compra = new Compra();
        $compra->PROVEEDOR = $this->proveedor_id;
        $compra->DESCRIPCION = '';
        $compra->METODO_PAGO = $this->metodoPagoSeleccionado;
        $compra->TOTAL = $this->totalVenta;
        $compra->USUARIO = auth()->id();
        $compra->save();

        foreach ($this->productosSeleccionados as $producto) {
            DB::table('DETALLE_COMPRA')->insert([
                'COMPRA' => $compra->id,
                'PRODUCTO' => $producto['id'],
                'PRECIO' => $producto['precio'],
                'CANTIDAD' => $producto['cantidad'],

            ]);

            // Descontar stock
            $productoModel = Producto::find($producto['id']);
            if ($productoModel) {
                $productoModel->CANTIDAD += $producto['cantidad'];
                $productoModel->save();
            }
        }

        $this->reset([
            'proveedor_id',
            'productosSeleccionados',
            'metodoPagoSeleccionado',
            'totalVenta',
        ]);
        //limpiar metodo de pago y nombre del cliente en el input
        $this->dispatch('limpiar');

        session()->flash('message', 'Venta registrada correctamente.');
    }

}
