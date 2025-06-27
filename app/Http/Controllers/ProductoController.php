<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $productos = Producto::where('CANTIDAD', '<=', 0)
            ->with(['detalleVenta.venta'])
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
                ? $ultimaVenta->venta->id
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


    private function obtenerProductosFiltrados(Request $request)
    {
        $producto = $request->input('nombre');
        $categorias = $request->input('categoria');
        $precio = $request->input('precio');
        $cantidad = $request->input('cantidad');
        $estado = $request->input('estado');

        return Producto::query()
            ->join('CATEGORIA', 'PRODUCTO.CATEGORIA', '=', 'CATEGORIA.CATEGORIA')
            ->select('PRODUCTO.*', DB::raw("CATEGORIA.CATEGORIA as categoria_nombre"))
            ->when($producto, fn($q) => $q->where('PRODUCTO.NOMBRE', 'like', '%' . $producto . '%'))
            ->when($categorias, fn($q) => $q->where('CATEGORIA.CATEGORIA', 'like', '%' . $categorias . '%'))
            ->when($precio !== null && $precio !== '', fn($q) => $q->where('PRODUCTO.PRECIO', '>=', $precio))
            ->when($cantidad, fn($q) => $q->where('PRODUCTO.CANTIDAD', $cantidad))
            ->when($estado !== null && $estado !== '', function ($q) use ($estado) {
                $estadoBool = $estado == '1' ? 1 : 0;
                $q->where('PRODUCTO.ESTADO', '=', $estadoBool);
            })
            ->orderBy('PRODUCTO.NOMBRE', 'asc')
            ->get();
    }

    public function exportarPdf(Request $request)
    {
        $productos = $this->obtenerProductosFiltrados($request);

        $pdf = Pdf::loadView('reportes.productos-disponibles', compact('productos'));
        return $pdf->download('productos-disponibles.pdf');
    }

    public function exportarExcel(Request $request)
    {
        $productos = $this->obtenerProductosFiltrados($request);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headers = ['ID', 'Nombre del producto', 'Categoría', 'Precio', 'Cantidad', 'Estado'];
        foreach ($headers as $index => $header) {
            $sheet->setCellValueByColumnAndRow($index + 1, 1, $header);
        }

        $fila = 2;
        foreach ($productos as $prod) {
            $sheet->setCellValueByColumnAndRow(1, $fila, $prod->ID);
            $sheet->setCellValueByColumnAndRow(2, $fila, $prod->NOMBRE);
            $sheet->setCellValueByColumnAndRow(3, $fila, $prod->categoria_nombre);
            $sheet->setCellValueByColumnAndRow(4, $fila, $prod->PRECIO);
            $sheet->setCellValueByColumnAndRow(5, $fila, $prod->CANTIDAD);
            $sheet->setCellValueByColumnAndRow(6, $fila, $prod->ESTADO ? 'Activo' : 'Inactivo');
            $fila++;
        }

        $writer = new Xlsx($spreadsheet);
        $nombreArchivo = 'productos-disponibles.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$nombreArchivo\"");
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }
    public function exportarHtml(Request $request)
    {
        $productos = $this->obtenerProductosFiltrados($request);

        $html = view('reportes.html.productos-html', compact('productos'))->render();

        return response($html)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="productos.html"');
    }

}

