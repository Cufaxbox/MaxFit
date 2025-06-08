<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Roles
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                    <x-alertas.success>
                        {{ session('success') }}
                    </x-alertas.success>
                    @endif
                    <a href="{{ route('roles.create_role') }}" 
                        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                        + Crear Nuevo Rol
                    </a>

                    <table class="w-full mt-4 border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border p-2">Nombre</th>
                                <th class="border p-2">Descripción</th>
                                <th class="border p-2 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td class="border p-2">{{ $rol->nombre }}</td>
                                    <td class="border p-2">{{ $rol->descripcion }}</td>
                                    <td class="border p-2 text-center">
                                        <a href="{{ route('roles.edit_role', $rol->id_roles) }}" 
                                            class="px-3 py-2 bg-yellow-500 text-white font-bold rounded-lg hover:bg-yellow-600">
                                            Editar
                                        </a>
                                        <form action="{{ route('roles.destroy', $rol->id_roles) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 bg-red-500 text-white font-bold rounded-lg hover:bg-red-600">
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