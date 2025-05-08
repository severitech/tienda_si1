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
    public function render()
    {
        // Llamamos a la función para obtener los usuarios
        
        /* Usamos DB para obtener los roles (o puedes definir un modelo para roles)
        compact('usuarios','clientes', 'metodo_pago', 'productos', 'ventas'))
        ->extends('layouts.app')
        ->section('content');
        // Pasamos los datos a la vista*/
         
        return view('livewire.ventas.ventas');
    }
}
