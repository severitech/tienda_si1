<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    protected $table = 'bitacora';

    protected $fillable = [
        'user_id',
        'accion',
        'modelo_afectado',
        'id_modelo_afectado',
        'direccion_ip',
        'user_agent',
    ];

    // Relación para obtener el usuario que realizó la acción
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}