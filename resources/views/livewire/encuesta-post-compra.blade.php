<div>
    @if($mostrarEncuesta)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">
                        ¡Compra Exitosa!
                    </h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500 mb-4">
                            Tu pedido ha sido procesado correctamente. ¿Te gustaría compartir tu experiencia con nosotros?
                        </p>
                        
                        <div class="mb-4">
                            <label for="comentario" class="block text-sm font-medium text-gray-700 mb-2">
                                Comentarios (opcional)
                            </label>
                            <textarea
                                wire:model="comentario"
                                id="comentario"
                                rows="4"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                placeholder="Cuéntanos qué te pareció tu experiencia de compra, sugerencias para mejorar, etc..."
                            ></textarea>
                            @error('comentario')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-center space-x-3">
                        <button
                            wire:click="saltarEncuesta"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500"
                        >
                            Saltar
                        </button>
                        <button
                            wire:click="guardarComentario"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            Enviar Comentario
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('message'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-md shadow-lg z-50">
            {{ session('message') }}
        </div>
    @endif

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('redirect-to-home', () => {
                setTimeout(() => {
                    window.location.href = '{{ route("home") }}';
                }, 2000);
            });
        });
    </script>
</div>
