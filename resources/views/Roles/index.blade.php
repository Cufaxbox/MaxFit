<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Gestión de Roles
        </h2>
    </x-slot>

    <div class="py-12 bg-[#121212] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#232323] shadow-md sm:rounded-lg">
                <div class="p-6 text-white">
                    @if (session('success'))
                        <x-alertas.success>
                            {{ session('success') }}
                        </x-alertas.success>
                    @endif

                    @if($permisos['puedeCrear'])
                        <a href="{{ route('roles.create_role') }}"
                           class="mb-4 inline-block px-5 py-2 bg-yellow-500 text-black font-semibold rounded-lg shadow hover:bg-yellow-400 transition duration-200">
                            + Crear Nuevo Rol
                        </a>
                    @endif

                    <div class="overflow-x-auto rounded-md mt-4">
                        <table class="w-full text-sm text-left text-gray-200 border border-gray-700">
                            <thead class="bg-[#2c2c2c] text-gray-100 uppercase tracking-wider text-xs">
                                <tr>
                                    <th class="px-6 py-3 border border-gray-700">Nombre</th>
                                    <th class="px-6 py-3 border border-gray-700">Descripción</th>
                                    <th class="px-6 py-3 text-center border border-gray-700">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($roles as $rol)
                                    <tr class="hover:bg-[#2e2e2e] transition">
                                        <td class="px-6 py-4 border border-gray-700">{{ $rol->nombre }}</td>
                                        <td class="px-6 py-4 border border-gray-700">{{ $rol->descripcion }}</td>
                                        <td class="px-6 py-4 border border-gray-700 text-center space-x-2">
                                            @if($permisos['puedeEditar'])
                                                <a href="{{ route('roles.edit_role', $rol->id_roles) }}"
                                                   class="px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-500 transition">
                                                    Editar
                                                </a>
                                            @endif

                                            @if($permisos['puedeEliminar'])
                                                <form action="{{ route('roles.destroy', $rol->id_roles) }}"
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-500 transition">
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
</x-app-layout>
