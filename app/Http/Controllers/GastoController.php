<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    public function index()
    {

        $gastos = Gasto::all();

        return view('gastos.index', compact('gastos'));
    }

}
