<div class="py-12">
    <!-- Mensajes de éxito / error -->
    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-500 text-white rounded-lg">{{ session('error') }}</div>
    @endif

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-500 text-white rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                <!-- ✅ Formulario de edición -->
                <form class="mb-5" wire:submit.prevent="updateRole">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del rol</label>
                        <input type="text" wire:model="nombre" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Nombre del rol" />
                        @error('nombre') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Descripción del rol</label>
                        <input type="text" wire:model.defer="descripcion"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Descripción del rol" />
                    </div>
                </form>

                <!-- ✅ Tabla de Módulos y Permisos -->
                <h3 class="text-lg font-bold mt-6 mb-2">Módulos y Permisos</h3>
                <div class="overflow-x-auto border border-gray-300 rounded-lg shadow-md">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Módulo</th>
                                @foreach ($permisos as $permiso)
                                    <th class="border px-4 py-2 text-center">{{ $permiso->nombre }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulos as $modulo)
                                <tr>
                                    <td class="border px-4 py-2 font-semibold">
                                        <label>
                                            <input type="checkbox" wire:model="selectedModulos"
                                                value="{{ $modulo->id_modulos }}" 
                                                @if(in_array($modulo->id_modulos, $selectedModulos)) checked @endif />
                                            {{ $modulo->nombre }}
                                        </label>
                                    </td>
                                    @foreach ($permisos as $permiso)
                                    <td class="border px-4 py-2 text-center">
                                        <input type="checkbox"
                                        wire:model="selectedPermisos.{{$modulo->id_modulos}}.{{$permiso->id_permisos}}"
                                        wire:key="{{ $modulo->id_modulos }}-{{ $permiso->id_permisos }}" 
                                        @if(isset($selectedPermisos[$modulo->id_modulos][$permiso->id_permisos])) checked @endif />
                                    </td>

                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- ✅ Botones de acción -->
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('roles.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white font-bold rounded-lg shadow-md hover:bg-gray-600">
                        Cancelar
                    </a>

                    <button type="submit" wire:click.prevent="updateRole"
                        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600">
                        Guardar Cambios
                    </button>
                </div>
                <div wire:loading wire:target="updateRole" class="text-blue-600 font-bold text-center mt-3">
                    Guardando cambios, por favor espera...
                </div>
            </div>
        </div>
    </div>
</div>