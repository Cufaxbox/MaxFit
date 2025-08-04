<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Editar Rutina
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg border border-gray-700">
                <div class="p-6 text-white">
                    <form action="{{ route('rutinas.update', ['rutina' => $rutina->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="cliente_id" value="{{ $cliente->id }}">

                        <!-- Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="block font-semibold text-white mb-2">Descripción:</label>
                            <textarea name="descripcion" id="descripcion" rows="4"
                                class="w-full p-3 rounded border border-gray-700 bg-[#121212] text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                required>{{ old('descripcion', $rutina->descripcion) }}</textarea>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center gap-4 mt-6">
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 shadow transition">
                                Actualizar Rutina
                            </button>

                            <a href="{{ route('rutinas.index') }}" wire:navigate
                                class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 shadow transition">
                                Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
