<?php

namespace App\Livewire\Ventas;

use Livewire\Component;
use App\Models\Venta;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ListaVentas extends Component
{
    public $perPage = 10;
    public $search = '';
    public function render()
    {// Llamamos a la función para obtener los usuarios
        $ventas = $this->obtenerVentas();

        // Usamos DB para obtener los roles (o puedes definir un modelo para roles)
      //  $roles = DB::table('ROL')->pluck('ROL');

        return view('livewire.ventas.lista-ventas',compact('ventas'))
            ->extends('layouts.app')
            ->section('content');
    }
    public function obtenerVentas()
    {
        return Venta::orderBy('CLIENTE')
            ->paginate($this->perPage);
    }
}
