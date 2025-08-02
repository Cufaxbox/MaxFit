<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Rutina
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('rutinas.store') }}" method="POST">
                        @csrf

                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="block text-gray-700">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" rows="4" class="border border-gray-300 rounded w-full p-2" required></textarea>
                        </div>

                        <!-- Botones -->
                        <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-700">
                            Guardar Rutina
                        </button>

                        <a href="{{ route('rutinas.index') }}" wire:navigate
                            class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                            Cancelar
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
