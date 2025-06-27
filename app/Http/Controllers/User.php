<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User as Usuario;
use Illuminate\Http\Request;

class User extends Controller
{
    public function mostrar()
    {
        $usuarios = Usuario::all();
        return view('trabajador.usuarios.mostrar', compact('usuarios'));
    }

    public function auditoria()
    {
        return view('trabajador.usuarios.auditoriausuario');
    }

    public function perfil_trabajador()
    {
        return view('perfil-usuario.perfil-trabajador');
    }

    public function actualizar(Request $request, $id)
    {
        /*$usuario = User::findOrFail($id);
        $usuario->update($request->all());

        return redirect()->route('usuarios.mostrar');*/
    }

    // 👇 Este método debe estar dentro de la clase también
    public function editar($id)
    {
       /* $usuario = User::findOrFail($id);
        $roles = DB::table('ROL')->pluck('ROL');
        return view('trabajador.usuarios.editar', compact('usuario', 'roles'));
    */}
}
