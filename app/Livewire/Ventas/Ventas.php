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
    public $cliente_id, $cantidad;
    public $productosSeleccionados = [];
    protected $listeners = [
        'clienteSeleccionado' => 'asignarCliente'
        ,
      //  'productoSeleccionado' => 'agregarProducto',
    ];



    public function render()
    {
        return view('livewire.ventas.ventas');
    }
    public function asignarCliente($id)
    {
        $this->cliente_id = $id;
    }

    public function agregarProducto($producto)
    {
        $id = $producto['id'];

        // Buscar si el producto ya fue agregado
        $existente = collect($this->productosSeleccionados)->firstWhere('id', $id);

        if ($existente) {
            // Si ya existe, solo aumentar la cantidad y recalcular el subtotal
            foreach ($this->productosSeleccionados as &$item) {
                if ($item['id'] === $id) {
                    $item['cantidad'] += $this->cantidad;
                    $item['subtotal'] = $item['cantidad'] * $item['precio'];
                    break;
                }
            }
        } else {
            // Si no existe, agregar nuevo producto
            $this->productosSeleccionados[] = [
                'id' => $id,
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $this->cantidad,
                'subtotal' => $producto['precio'],
            ];
        }
    }
}
