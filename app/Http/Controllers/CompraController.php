<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompraController extends Controller
{
     public function mostrar()
    {
        return view('trabajador.compra.mostrar');
    }
}
