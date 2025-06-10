<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
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




    public function reporte_pdf_sinStock()
    {
        // Carga productos sin stock con ventas relacionadas (asegúrate que la relación sea plural)
        $productos = Producto::where('CANTIDAD', '<=', 0)
            ->with(['detalleVenta.venta']) // relación plural
            ->get();

        foreach ($productos as $producto) {
            $ultimaVenta = $producto->detalleVenta
                ->filter(fn($dv) => $dv->venta !== null)
                ->sortByDesc(fn($dv) => $dv->venta->created_at)
                ->first();

            $producto->fecha_ultima_venta = $ultimaVenta
                ? Carbon::parse($ultimaVenta->venta->created_at)->format('d/m/Y H:i')
                : 'Sin ventas';

            $producto->id_ultima_venta = $ultimaVenta && $ultimaVenta->venta
                ? $ultimaVenta->venta->id // o 'id' si así lo tienes en tu tabla
                : '-';
        }

        $pdf = Pdf::loadView('reportes.productos-sin-stock', compact('productos'));

        return $pdf->download('productos-sin-stock.pdf');
    }


    public function reporte_sin_stock()
    {
        return view('trabajador.productos.reportes');
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


    public function exportarPdf(Request $request)
    {
        $query = Producto::query();

        if ($request->categoria) {
            $query->where('CATEGORIA', 'like', '%' . $request->categoria . '%');
        }
        if ($request->producto) {
            $query->where('NOMBRE', 'like', '%' . $request->producto . '%');
        }
        if ($request->precio) {
            $query->where('PRECIO', $request->precio);
        }
        if ($request->cantidad) {
            $query->where('CANTIDAD', $request->cantidad);
        }
        if ($request->estado !== null && $request->estado !== '') {
            $query->where('ESTADO', $request->estado);
        }

        $productos = $query->orderBy('NOMBRE')->get();

        $pdf = Pdf::loadView('reportes.productos-disponibles', compact('productos'));

        return $pdf->download('productos-disponibles.pdf');
    }

}

