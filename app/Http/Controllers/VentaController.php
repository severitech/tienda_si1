<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function mostrar()
    {
        return view('trabajador.venta.mostrar');
    }
    public function listaventas()
    {
        return view('trabajador.venta.lista-ventas');
    }
}
