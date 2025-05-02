<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class User extends Controller
{
    public function mostrar()
    {
        return view('trabajador.usuarios.mostrar');
    }
}
