<?php

namespace App\Services;

use App\Models\Bitacora;
use Illuminate\Support\Facades\Auth;

class BitacoraService
{
    public static function logAction(string $accion, $modeloAfectado = null)
    {
        Bitacora::create([
            'user_id' => Auth::id(),
            'accion' => $accion,
            'modelo_afectado' => $modeloAfectado ? get_class($modeloAfectado) : null,
            'id_modelo_afectado' => $modeloAfectado ? $modeloAfectado->getKey() : null,
            'direccion_ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}