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
            // Verifica si el producto ya fue agregado
            $existente = collect($this->productosSeleccionados)->firstWhere('id', $productoData['id']);

            if ($existente) {
                // Si ya existe, solo aumentar la cantidad y recalcular el subtotal
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

    public function registrarVenta()
    {
        session()->flash('message', "cliente" . $this->cliente_id . "\nmetodoPago: " . $this->metodoPagoSeleccionado . "\n totalVenta: " . $this->totalVenta. 'usuario: ' . auth()->id());
        /*  $venta = new Venta();
          $venta->cliente_id = $this->cliente_id;
          $venta->metodo_pago = $this->metodoPago;
          $venta->total = $this->totalVenta;
          $venta->save();

          // Guardar los productos vendidos
          foreach ($this->productosSeleccionados as $producto) {
              DB::table('venta_producto')->insert([
                  'venta_id' => $venta->id,
                  'producto_id' => $producto['id'],
                  'cantidad' => $producto['cantidad'],
                  'precio' => $producto['precio'],
                  'subtotal' => $producto['subtotal'],
              ]);
          }

          // Reiniciar los valores después de guardar la venta
          $this->reset(['cliente_id', 'productosSeleccionados', 'metodoPago', 'totalVenta']);
          session()->flash('message', 'Venta guardada exitosamente.');*/
    }


}
