<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    public function index(){
        return view('trabajador.compra.lista-compra');
    }
}
