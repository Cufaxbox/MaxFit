<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Módulo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('modulos.update', ['modulo' => $modulo->id_modulos]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <label for="nombre" class="block text-gray-700">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" value="{{ $modulo->nombre }}"
                               class="border border-gray-300 rounded w-full p-2" required>

                        <label for="descripcion" class="block text-gray-700 mt-4">Descripción:</label>
                        <textarea name="descripcion" id="descripcion"
                                  class="border border-gray-300 rounded w-full p-2">{{ $modulo->descripcion }}</textarea>

                        <!-- Botón de actualizar -->
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                            Actualizar Módulo
                        </button>

                        <a href="{{ route('modulos.index') }}" wire:navigate
                            class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                            Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>