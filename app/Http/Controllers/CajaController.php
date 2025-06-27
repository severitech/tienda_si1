<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Barryvdh\DomPDF\Facade\Pdf;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('trabajador.caja.registro-caja');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function arqueo()
    {
        return view('trabajador.caja.arqueo');
    }

    public function exportar(Request $request, $formato)
    {
        $cajas = Caja::with('usuario')
            ->when($request->inicio, fn($q) => $q->whereDate('created_at', '>=', $request->inicio))
            ->when($request->fin, fn($q) => $q->whereDate('created_at', '<=', $request->fin))
            ->when($request->usuario, fn($q) => $q->where('USUARIO', $request->usuario))
            ->get();

        if ($formato === 'pdf') {
            $pdf = Pdf::loadView('reportes.cierre-caja', compact('cajas'));
            return $pdf->download('cierre-caja.pdf');
        }

        if ($formato === 'html') {
            $html = view('reportes.html.cierre-html', compact('cajas'))->render();
            return response($html)
                ->header('Content-Type', 'text/html')
                ->header('Content-Disposition', 'attachment; filename="cierre-caja.html"');
        }

        if ($formato === 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            $sheet->setCellValue('A1', 'ID');
            $sheet->setCellValue('B1', 'Descripción');
            $sheet->setCellValue('C1', 'Declarado');
            $sheet->setCellValue('D1', 'Cierre');
            $sheet->setCellValue('E1', 'Diferencia');
            $sheet->setCellValue('F1', 'Usuario');
            $sheet->setCellValue('G1', 'Fecha');

            $fila = 2;
            foreach ($cajas as $caja) {
                $sheet->setCellValue("A$fila", $caja->ID);
                $sheet->setCellValue("B$fila", $caja->DESCRIPCION);
                $sheet->setCellValue("C$fila", $caja->DECLARADO);
                $sheet->setCellValue("D$fila", $caja->CIERRE);
                $sheet->setCellValue("E$fila", $caja->DIFERENCIA);
                $sheet->setCellValue("F$fila", $caja->usuario?->name);
                $sheet->setCellValue("G$fila", $caja->created_at->format('Y-m-d H:i'));
                $fila++;
            }

            $writer = new Xlsx($spreadsheet);
            $nombre = 'cierre-caja.xlsx';

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header("Content-Disposition: attachment; filename=\"$nombre\"");
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
            exit;
        }

        return back()->with('error', 'Formato no válido');
    }
}
