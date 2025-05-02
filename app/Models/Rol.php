<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'ROL';

    public function rol()
    {
        return $this->hasMany(User::class, 'ROL', 'ROL');
    }
}
