<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nueva Actividad
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1f1f1f] shadow-md rounded-lg p-6 text-white">
                <form action="{{ route('actividades.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nombre" class="block mb-1 text-sm font-medium text-gray-300">Nombre:</label>
                        <input type="text" name="nombre" id="nombre"
                            class="w-full px-4 py-2 rounded-md border border-gray-600 bg-[#2a2a2a] text-white focus:outline-none focus:ring-2 focus:ring-yellow-400"
                            required>
                    </div>

                    <div class="flex items-center gap-4 mt-6">

                    <a href="{{ route('actividades.index') }}" wire:navigate
                            class="inline-block px-4 py-2 bg-gray-700 text-white font-medium rounded-md shadow hover:bg-gray-600 transition">
                            Cancelar
                        </a>
                        
                        <button type="submit"
                            class="inline-block px-4 py-2 bg-yellow-500 text-black font-medium rounded-md shadow hover:bg-yellow-600 transition">
                            Guardar Actividad
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
