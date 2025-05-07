<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{

    public function index()
    {
        // Obtener los productos activos y agruparlos por su categoría
        $productosPorCategoria = Producto::with('categoria')
            ->where('ESTADO', true)
            ->get()
            ->groupBy(fn($producto) => $producto->categoria?->CATEGORIA); // 👈 importante  

        return view('welcome', compact('productosPorCategoria'));
    }
    
    public function mostrar()
    {
        $productos = Producto::all();
        return view('trabajador.productos.mostrar', compact('productos'));
    }
    
    
    public function editar($id)
    {
        $producto = Producto::findOrFail($id);
        //return view('trabajador.productos.editar', compact('producto'));
    }



    public function actualizar(Request $request, $id)
{
    try {
        $producto = Producto::findOrFail($id);
        $producto->NOMBRE = $request->input('nombre');
        $producto->CATEGORIA = $request->input('descripcion');
        $producto->PRECIO = $request->input('precio');
        $producto->save();

        return redirect()->back()->with('success', 'Producto actualizado correctamente.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al actualizar el producto.');
    }
}

    public function crear()
    {
        // Mostrar formulario para agregar producto
        //return view('trabajador.productos.crear');
    }
    public function destroy($id)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
    
            return redirect()->back()->with('success', 'Producto eliminado correctamente.');
        } catch (\Exception $e) {
            dd($e->getMessage()); // <-- Muestra el error exacto
            return redirect()->back()->with('error', 'Error al eliminar el producto.');
        }
    }
    
    

}

