<?php

namespace App\Exports;

use App\Models\Descuento;
use Maatwebsite\Excel\Concerns\FromCollection; // Le dice al paquete que vamos a exportar una colección de Laravel.
use Maatwebsite\Excel\Concerns\WithHeadings;   // Nos permite definir los títulos de las columnas.
use Maatwebsite\Excel\Concerns\WithMapping;   // Nos permite formatear cada fila.

class DescuentosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Descuento::with('productos')->get();
    }

    /* opcional*/
    public function headings(): array
    {
        return [
            'ID',
            'Nombre del Descuento',
            'Tipo',
            'Valor',
            'Productos Aplicables',
            'Activo',
            'Fecha de Creación'
        ];
    }

    /**
    * @param Descuento $descuento
    */
    public function map($descuento): array
    {
        return [
            $descuento->id,
            $descuento->nombre,
            $descuento->tipo,
            $descuento->valor,

            $descuento->productos->pluck('NOMBRE')->join(', '),

            $descuento->activo ? 'Sí' : 'No', // para mostrar 'Sí' o 'No' en lugar de 1 o 0
            $descuento->created_at->format('d/m/Y H:i'), // Formateamos la fecha para que sea legible
        ];
    }
}
