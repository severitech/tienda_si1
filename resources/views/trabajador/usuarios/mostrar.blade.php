<x-layouts.app :title="__('Usuarios')">
    <div class="p-4">
        <h1 class="text-2xl font-bold mb-4">Gestión de Usuarios</h1>

        <table class="table-auto w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2 text-black bg-white">Nombre</th>
                    <th class="border px-4 py-2 text-black bg-white">Paterno</th>
                    <th class="border px-4 py-2 text-black bg-white">Email</th>
                    <th class="border px-4 py-2 text-black bg-white">Rol</th>
                    <th class="border px-4 py-2 text-black bg-white">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usuario)
                <tr>
                    <form action="{{ route('usuarios.actualizar', $usuario->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td class="border px-2 py-1">
                            <input type="text" name="nombre" value="{{ $usuario->nombre }}" class="w-full border p-1 text-sm text-black bg-white">
                        </td>
                        <td class="border px-2 py-1">
                            <input type="text" name="paterno" value="{{ $usuario->paterno }}" class="w-full border p-1 text-sm text-black bg-white">
                        </td>
                        <td class="border px-2 py-1">
                            <input type="email" name="email" value="{{ $usuario->email }}" class="w-full border p-1 text-sm text-black bg-white">
                        </td>
                        <td class="border px-2 py-1">
                            <select name="ROL" class="w-full border p-1 text-sm text-black bg-white">
                                @foreach($roles as $rol)
                                    <option value="{{ $rol }}" @if($usuario->ROL == $rol) selected @endif>{{ ucfirst($rol) }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="border px-2 py-1 text-center">
                            <button type="submit" class="bg-green-500 text-white px-2 py-1 rounded text-sm">Guardar</button>
                        </td>
                    </form>
                </tr>
                <tr>
                    <td colspan="5" class="border text-center">
                        <form action="{{ route('usuarios.eliminar', $usuario->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline text-sm" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
