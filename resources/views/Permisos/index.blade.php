<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Lista de Permisos
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
                <a href="{{ route('permisos.create') }}" wire:navigate
                    class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                    + Nuevo Permiso
                </a>
                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Nombre</th>
                                <th class="border border-gray-300 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permisos as $permiso)
                            <tr class="border border-gray-300">
                                <td class="px-4 py-2">{{ $permiso->nombre }}</td>
                                    <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                        <a href="{{ route('permisos.edit', ['permiso' => $permiso->id_permisos]) }}" wire:navigate
                                            class="px-4 py-2 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600">
                                            Editar
                                        </a>

                                        <form action="{{ route('permisos.destroy', ['permiso' => $permiso->id_permisos]) }}" method="POST" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                class="px-4 py-2 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600">
                                                Eliminar
                                            </button>
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
</x-app-layout>