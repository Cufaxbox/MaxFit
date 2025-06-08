<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nuevo Permiso
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('permisos.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="nombre" class="block text-gray-700">Nombre:</label>
                            <input type="text" name="nombre" id="nombre" class="border border-gray-300 rounded w-full p-2" required>
                        </div>

                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                            Guardar Permiso
                        </button>

                        <a href="{{ route('permisos.index') }}" wire:navigate
                            class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                            Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>