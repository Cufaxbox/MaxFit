<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Lista de Actividades
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow sm:rounded-lg">
                <div class="p-6 text-gray-100">

                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    @if($permisos['puedeCrear'])
                        <a href="{{ route('actividades.create') }}" wire:navigate
                           class="inline-block mb-4 px-4 py-2 bg-yellow-500 text-black font-medium rounded-md shadow hover:bg-yellow-600 transition">
                            + Nueva Actividad
                        </a>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-300 border border-gray-700">
                            <thead class="bg-gray-800 text-gray-300">
                                <tr>
                                    <th class="px-4 py-3 border-b border-gray-700">Nombre</th>
                                    <th class="px-4 py-3 border-b border-gray-700 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($actividades as $actividad)
                                    <tr class="hover:bg-gray-900 transition">
                                        <td class="px-4 py-2 border-b border-gray-700">{{ $actividad->nombre }}</td>
                                        <td class="px-4 py-2 border-b border-gray-700 flex justify-center items-center gap-2">

                                            @if($permisos['puedeEditar'])
                                                <a href="{{ route('actividades.edit', ['actividad' => $actividad->id_actividades]) }}"
                                                   wire:navigate
                                                   class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">
                                                    Editar
                                                </a>
                                            @endif

                                            @if($permisos['puedeEliminar'])
                                                <form action="{{ route('actividades.destroy', ['actividad' => $actividad->id_actividades]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('¿Estás seguro de que querés eliminar esta actividad?')"
                                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-medium">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

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
