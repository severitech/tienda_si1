@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegación de paginación" class="flex items-center justify-between mt-4 text-sm">

        {{-- Botón "Anterior" --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-gray-600 bg-gray-300 rounded">Anterior</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-white transition rounded bg-zinc-600 hover:bg-zinc-700">Anterior</a>
        @endif

        {{-- Elementos numerados --}}
        <div class="flex mx-2 space-x-1">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 font-bold text-white rounded bg-zinc-700">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="px-4 py-2 transition rounded text-zinc-700 bg-zinc-100 hover:bg-zinc-300">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Botón "Siguiente" --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-white transition rounded bg-zinc-600 hover:bg-zinc-700">Siguiente</a>
        @else
            <span class="px-4 py-2 text-gray-600 bg-gray-300 rounded">Siguiente</span>
        @endif

    </nav>
@endif
