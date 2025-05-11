<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Asegúrate de que existe un rol con ID 1 o cámbialo según el rol que deseas asignar
        User::create([
            'nombre' => 'Jhon',
            'paterno' => 'Salas',
            'materno' => 'Rodas',
            'telefono' => '78945612',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678'),
            'ROL' => 'administrador', // como texto
        ]);
    }
}
