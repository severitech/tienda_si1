<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User; // Importa el modelo User
use Illuminate\Support\Facades\Hash; // Importa la clase Hash

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            ['nombre' => 'Isael', 'paterno' => 'Ortiz', 'materno' => 'Flores', 'email' => 'isaelortiz74@gmail.com'],
            ['nombre' => 'David', 'paterno' => 'Sequeiros', 'materno' => 'Cruz', 'email' => 'sequeiros.dc44@gmail.com'],
            ['nombre' => 'Jhon', 'paterno' => 'Salas', 'materno' => 'Quispe', 'email' => 'jhonsalas68@gmail.com'],
            ['nombre' => 'Alex', 'paterno' => 'Man', 'materno' => 'Alsta', 'email' => 'alex.lx.man.alstaraciend@gmail.com'],
            ['nombre' => 'Douglas', 'paterno' => 'Padilla', 'materno' => 'Severiche', 'email' => 'padilladouglas6@gmail.com'],
            ['nombre' => 'María', 'paterno' => 'Torrez', 'materno' => 'Vargas', 'email' => 'admin6@correo.com'],
        ];

        foreach ($admins as $admin) {
            User::create([
                'nombre' => $admin['nombre'],
                'paterno' => $admin['paterno'],
                'materno' => $admin['materno'],
                'telefono' => '70000000',
                'email' => $admin['email'],
                'password' => Hash::make('12346578'), // Asegúrate de cambiar la contraseña por algo más seguro
                'ROL' => 'administrador',
            ]);
        }
    }
}
