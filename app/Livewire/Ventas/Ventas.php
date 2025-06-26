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
    public $metodoPagoSeleccionado;

    // ==================================================================
    // <-- CAMBIO 1: Se añaden las nuevas propiedades para los totales -->
    // Se elimina la propiedad "$totalVenta" y se reemplaza por estas dos.
    // ==================================================================
    public $totalSinDescuento = 0;
    public $totalFinal = 0;

    protected $listeners = [
        'clienteSeleccionado' => 'asignarCliente',
        'enviarProducto' => 'recibirProducto',
        'enviarMetodoPagoVentas' => 'recibirMetodoPago',
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

    // <-- CAMBIO: Se re-incluyen los métodos solicitados -->
    public function mostrarvalores()
    {
        // session()->flash('message',"Mensaje". $this->cliente_id);
        session()->flash('message', 'Producto(s) agregados: ' . implode(', ', array_column($this->productosSeleccionados, 'nombre' . ' ' . 'cantidad' . ' ' . 'precio')));
    }

    public function productoSeleccionado($productos)
    {
        $this->productosSeleccionados = $productos;
    }
    // <-- FIN DEL CAMBIO -->

    // ====================================================================================
    // <-- CAMBIO 2: El método 'recibirProducto' se reescribe para incluir los descuentos -->
    // ====================================================================================
    public function recibirProducto($productoData)
    {
        // Se usa with('descuentos') para cargar la relación y optimizar la consulta
        $producto = Producto::with('descuentos')->find($productoData['id']);

        if ($producto) {
            $indiceExistente = null;
            // Buscamos si el producto ya está en el carrito
            foreach ($this->productosSeleccionados as $key => $item) {
                if ($item['id'] === $productoData['id']) {
                    $indiceExistente = $key;
                    break;
                }
            }

            if ($indiceExistente !== null) {
                // Si ya existe, solo actualizamos la cantidad
                $this->productosSeleccionados[$indiceExistente]['cantidad'] += $productoData['cantidad'];
                $itemData = $this->productosSeleccionados[$indiceExistente];
            } else {
                // Si no existe, preparamos el array base del producto
                $itemData = [
                    'id' => $productoData['id'],
                    'nombre' => $producto->NOMBRE,
                    'precio' => $productoData['precio'],
                    'cantidad' => $productoData['cantidad'],
                ];
            }

            // --- LÓGICA DE CÁLCULO DE DESCUENTOS ---
            $descuentoAplicado = $producto->descuentos()->where('activo', true)->first();

            $itemData['descuento_texto'] = 'N/A';
            $itemData['subtotal_original'] = $itemData['precio'] * $itemData['cantidad'];
            $descuentoMonto = 0;

            if ($descuentoAplicado) {
                if ($descuentoAplicado->tipo == 'fijo') {
                    $descuentoMonto = $descuentoAplicado->valor * $itemData['cantidad'];
                    $itemData['descuento_texto'] = "Bs. -{$descuentoAplicado->valor} c/u";
                } elseif ($descuentoAplicado->tipo == 'porcentaje') {
                    $descuentoMonto = ($itemData['subtotal_original'] * $descuentoAplicado->valor) / 100;
                    $itemData['descuento_texto'] = "-{$descuentoAplicado->valor}%";
                } elseif ($descuentoAplicado->tipo == '2x1') {
                    $unidadesAPagar = floor($itemData['cantidad'] / 2) + ($itemData['cantidad'] % 2);
                    $descuentoMonto = ($itemData['cantidad'] - $unidadesAPagar) * $itemData['precio'];
                    $itemData['descuento_texto'] = "Oferta 2x1";
                }
            }

            $itemData['subtotal_final'] = $itemData['subtotal_original'] - $descuentoMonto;
            // --- FIN DE LA LÓGICA DE CÁLCULO DE DESCUENTOS ---

            // Actualizamos o añadimos el producto a la lista
            if ($indiceExistente !== null) {
                $this->productosSeleccionados[$indiceExistente] = $itemData;
            } else {
                $this->productosSeleccionados[] = $itemData;
            }

            $this->actualizarTotales();

        } else {
            session()->flash('message', 'Producto no encontrado.');
        }
    }

    public function eliminar($id)
    {
        $this->productosSeleccionados = array_filter($this->productosSeleccionados, function ($producto) use ($id) {
            return $producto['id'] !== $id;
        });

        // <-- CAMBIO 3: Se llama al nuevo método para recalcular los totales -->
        $this->actualizarTotales();
    }

    // <-- CAMBIO 4: Se añade el nuevo método para actualizar los totales -->
    public function actualizarTotales()
    {
        $this->totalSinDescuento = 0;
        $this->totalFinal = 0;

        foreach ($this->productosSeleccionados as $item) {
            $this->totalSinDescuento += $item['subtotal_original'] ?? 0;
            $this->totalFinal += $item['subtotal_final'] ?? 0;
        }
    }

    public function registrarVenta()
    {
        // Validaciones previas (se mantienen igual)
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
        // <-- CAMBIO 5: Se usa el total final con descuentos -->
        $venta->TOTAL = $this->totalFinal;
        $venta->USUARIO = auth()->id();
        $venta->save();

        foreach ($this->productosSeleccionados as $producto) {
            DB::table('DETALLE_VENTA')->insert([
                'VENTA' => $venta->id,
                'PRODUCTO' => $producto['id'],
                'PRECIO' => $producto['precio'],
                'CANTIDAD' => $producto['cantidad'],
            ]);
        }

        // <-- CAMBIO 6: Se resetean las nuevas propiedades de totales -->
        $this->reset([
            'cliente_id',
            'productosSeleccionados',
            'metodoPagoSeleccionado',
            'totalSinDescuento',
            'totalFinal',
        ]);
        
        $this->dispatch('limpiar');
        session()->flash('message', 'Venta registrada correctamente.');
    }
}
