<?php

namespace App\Observers;

use App\Services\BitacoraService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ModelObserver
{
    // Obtiene el nombre base del modelo (ej. "Producto")
    private function getModelName(Model $model): string
    {
        return class_basename($model);
    }

    public function created(Model $model): void
    {
        // Solo registra si hay un usuario autenticado
        if (Auth::check()) {
            $modelName = $this->getModelName($model);
            BitacoraService::logAction("Creó {$modelName}", $model);
        }
    }

    public function updated(Model $model): void
    {
        if (Auth::check()) {
            $modelName = $this->getModelName($model);
            BitacoraService::logAction("Actualizó {$modelName}", $model);
        }
    }

    public function deleted(Model $model): void
    {
        if (Auth::check()) {
            $modelName = $this->getModelName($model);
            BitacoraService::logAction("Eliminó {$modelName}", $model);
        }
    }
}