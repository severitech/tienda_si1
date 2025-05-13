@if (session('hola'))
    <div x-data="{ isVisible: true }" 
    x-init="setTimeout(() => { isVisible = false }, 2000)"
    x-show="isVisible"

        class="flex items-center p-4 mb-4 text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400 bottom-4 left-4">

        <svg class="w-4 h-4 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
            viewBox="0 0 20 20">
            <path
                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
        </svg>

        <span class="sr-only">Info</span>

        <div class="text-sm font-medium ms-3">
            {{ session('message') }}
        </div>
    </div>
@endif
