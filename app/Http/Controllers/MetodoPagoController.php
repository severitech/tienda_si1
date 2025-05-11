<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MetodoPago;

class   MetodoPagoController extends Controller
{
    public function index()
    {
        // Obtener todos los métodos de pago
        $metodos = MetodoPago::all();

        // Retornar la vista con los métodos de pago
        return view('trabajador.metodo_pago.index', compact('metodos'));
    }
    public function create()    
    {
        return view('trabajador.metodo_pago.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'METODO_PAGO' => 'required|string|max:50|unique:METODO_PAGO'
        ]);

        MetodoPago::create($request->only('METODO_PAGO'));

        return redirect()->route('metodo_pago.index')->with('success', 'Método creado correctamente.');
    }
    public function edit($METODO_PAGO)
    {
        $metodo = MetodoPago::findOrFail($METODO_PAGO);
        return view('trabajador.metodo_pago.edit', compact('metodo'));
    }

    public function update(Request $request, $METODO_PAGO)
    {
        $validated = $request->validate([
            'METODO_PAGO' => 'required|string|max:255',
        ]);

        $metodo = MetodoPago::findOrFail($METODO_PAGO);
        $metodo->update($validated);

        return redirect()->route('metodo_pago.index')->with('success', 'Método de pago actualizado correctamente.');
    }

    public function destroy($METODO_PAGO)
    {
        $metodo = MetodoPago::findOrFail($METODO_PAGO); // Buscar el método de pago
        $metodo->delete(); // Eliminar el método de pago
        return redirect()->route('metodo_pago.index')->with('success', 'Método de pago eliminado');
    }
};
