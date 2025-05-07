<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $nombre = '';
    public string $paterno = '';
    public string $materno = '';
    public string $telefono = '';
    public string $email = '';
    public string $password = '';
    public bool $estado = true; // Cambiar de string a bool
    public string $rol = 'vendedor';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        // Validación
        $validated = $this->validate([
            'nombre' => ['required', 'string', 'max:100'],
            'paterno' => ['required', 'string', 'max:100'],
            'materno' => ['required', 'string', 'max:100'],
            'telefono' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'estado' => ['required', 'boolean'],  // Validar como booleano
            'rol' => ['required', 'string'],
        ]);

        // Hash de la contraseña
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);
        $user->update([
            'ROL' => 'cliente'
    ]);
        event(new Registered(($user)));

        // Iniciar sesión del usuario
        Auth::login($user);

        // Redirigir al dashboard
        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
};
?>


<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Crear cuenta')" :description="__('Ingrese sus datos a continuación para crear su cuenta')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <!-- Name -->
        <flux:input wire:model="nombre" :label="__('Nombre Completo:')" type="text" required autofocus
            autocomplete="nombre" :placeholder="__('Nombre')" />


        <!-- Paterno -->
        <flux:input wire:model="paterno" :label="__('Apellido Paterno:')" type="text" required autofocus
            autocomplete="paterno" :placeholder="__('Apellido')" />

        <!-- Materno -->
        <flux:input wire:model="materno" :label="__('Apellido Materno:')" type="text" required autofocus
            autocomplete="materno" :placeholder="__('Apellido')" />

        <!-- telelfono -->
        <flux:input wire:model="telefono" :label="__('N° de Celular:')" type="text" required autofocus
            autocomplete="telefono" :placeholder="__('7123456789')" />


        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Correo Electrónico:')" type="email" required autocomplete="email"
            placeholder="email@ejemplo.com" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Contraseña:')" type="password" required
            autocomplete="new-password" :placeholder="__('Contraseña')" />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirmar Contraseña:')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirmar Contraseña')" />

        <div class="flex items-center justify-end">
            <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Crear cuenta') }}
            </flux:button>
        </div>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
        {{ __('Ya tienes una cuenta creada? ') }}
        <flux:link :href="route('login')" wire:navigate>{{ __('Ingresar') }}</flux:link>
    </div>
</div>
