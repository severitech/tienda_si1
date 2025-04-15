<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="/src/styles.css" rel="stylesheet">
    <title>Laravel</title>
    <link href="/path/to/flux-ui.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    @vite('resources/css/app.css')
    {{-- @fluxAppearance --}}
    <!-- Styles -->
    @fluxAppearance
</head>

<body
    class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Rol: <span class="font-semibold">{{ Auth::user()->ROL }}</span>
                    </p>

                    @if (Auth::user()->ROL !== 'cliente')
                    <flux:button variant="filled"><a href="{{ url('/dashboard') }}" class=" dark:text-gray-300">Dashboard</a></flux:button>
                    @endif
         
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn text-red-500">Cerrar sesión</button>
                    </form>
                @endauth
                @include('cliente.carrito')
                @guest
                <flux:button ><a href="{{ route('login') }}" class="btn">Log in</a></flux:button>
                    @if (Route::has('register'))
                    <flux:button variant="filled" ><a href="{{ route('register') }}" class="btn">Register</a></flux:button>
                    @endif
                @endguest
            </nav>
        @endif
    </header>


    <div
        class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <main class="flex max-w-[335px] w-full flex-col-reverse lg:max-w-4xl lg:flex-row">
            {{-- @yield('content') --}}
            {{-- Mostrar componentes específicos dentro del main --}}
           
            @include('cliente.productos')
           
            {{-- También puedes usar @yield si tienes secciones más dinámicas que deseas agregar --}}
        </main>

        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </div>
    @fluxScripts
    
</body>

</html>
