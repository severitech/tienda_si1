<?php

namespace App\Http\Livewire\Compra;

use Livewire\Component;
use App\Models\Compra;
use App\Models\DetalleCompra;

class DetalleModal extends Component
{
    public $compraId;
    public $compra;
    public $detalles = [];

    protected $listeners = ['loadCompra' => 'loadCompra'];

    public function mount()
    {
        $this->compra = null;
        $this->detalles = [];
    }

    public function loadCompra($data)
    {
        $this->compraId = $data['id'];
        $this->compra = Compra::with(['usuario', 'proveedor'])->find($this->compraId);
        $this->detalles = DetalleCompra::where('COMPRA', $this->compraId)->with('producto')->get();
    }

    public function render()
    {
        return view('livewire.compra.detalle-modal');
    }
} 