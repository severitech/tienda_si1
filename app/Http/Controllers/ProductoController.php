<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
{
    // Obtener los productos activos y agruparlos por su categoría
    $productosPorCategoria = Producto::with('categoria')  // Asumimos que hay una relación 'categoria'
        ->where('ESTADO', true)  // Solo productos activos
        ->get()
        ->groupBy('categoria.nombre');  // Agrupamos por el nombre de la categoría

    return view('welcome', compact('productosPorCategoria'));
}


    public function showProductos()
{
    // Asumimos que tienes una relación entre Producto y Categoría
    $productosPorCategoria = Producto::with('categoria')
        ->get()
        ->groupBy('categoria.nombre');  // Agrupa los productos por categoría

    return view('welcome', compact('productos'));
}

}

