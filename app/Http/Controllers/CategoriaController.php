<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
   public function index()
    {
        // Obtener todos los métodos de pago
        $categoria = Categoria::all();

        // Retornar la vista con los métodos de pago
        return view('trabajador.categoria.mostrar', compact('categoria'));
    }
}
