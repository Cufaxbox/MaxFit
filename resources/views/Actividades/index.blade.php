<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Actividades
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                    <x-alertas.success>
                        {{ session('success') }}
                    </x-alertas.success>
                    @endif

                     @if($permisos['puedeCrear'])
                    <a href="{{ route('actividades.create') }}" wire:navigate
                        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                        + Nueva Actividad
                    </a>
                    @endif
                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                                <th class="border border-gray-300 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($actividades as $actividad)
                            <tr class="border border-gray-300">
                                <td class="px-4 py-2">{{ $actividad->nombre }}</td>
                                <td class="px-4 py-2 flex justify-center items-center space-x-2">

                                  @if($permisos['puedeEditar'])
                                    <a href="{{ route('actividades.edit', ['actividad' => $actividad->id_actividades]) }}" wire:navigate
                                        class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                                        Editar
                                    </a>
                                    @endif
                                    <form action="{{ route('actividades.destroy', ['actividad' => $actividad->id_actividades]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        @if($permisos['puedeEliminar'])
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600">
                                            Eliminar
                                        </button>
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($actividades->hasPages())
    <div class="mt-6 flex justify-center bg-gray-100 p-4 rounded shadow">
        {{ $actividades->links() }}
    </div>
    @endif
</x-app-layout>