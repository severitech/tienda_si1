<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
    {
        $productos = Producto::select('ID', 'NOMBRE', 'PRECIO', 'CANTIDAD')
        ->where('ESTADO', true)
        ->get();
        return view('welcome', compact('productos'));
    }
}

