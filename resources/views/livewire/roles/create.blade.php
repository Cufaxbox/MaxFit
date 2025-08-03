<div class="py-12">
    @if (session()->has('error'))
        <div class="mb-4 p-3 bg-red-600 text-white rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    @if (session()->has('success'))
        <div class="mb-4 p-3 bg-green-600 text-white rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-[#1a1a1a] shadow-md sm:rounded-lg text-white">
            <div class="p-6">

                <!-- Formulario para agregar un nuevo rol -->
                <form class="mb-5" wire:submit.prevent="saveRole">
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Nombre del rol</label>
                        <input type="text" wire:model="nombre" required
                            class="w-full px-3 py-2 bg-[#121212] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                            placeholder="Nombre del rol" />
                        @error('nombre') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Descripción del rol</label>
                        <input type="text" wire:model.defer="descripcion"
                            class="w-full px-3 py-2 bg-[#121212] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-white"
                            placeholder="Descripción del rol" />
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="es_instructor" class="form-checkbox text-blue-500 focus:ring-blue-400">
                            <span class="ml-2 text-sm">Instructor</span>
                        </label>
                    </div>
                </form>

                <!-- Tabla de Módulos y Permisos -->
                <h3 class="text-lg font-bold mt-6 mb-2">Módulos y Permisos</h3>
                <div class="overflow-x-auto border border-gray-700 rounded-lg shadow-inner">
                    <table class="min-w-full text-sm">
                        <thead class="bg-[#2a2a2a] text-white">
                            <tr>
                                <th class="border border-gray-700 px-4 py-2 text-left">Módulo</th>
                                @foreach ($permisos as $permiso)
                                    <th class="border border-gray-700 px-4 py-2 text-center">{{ $permiso->nombre }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($modulos as $modulo)
                                <tr class="hover:bg-[#2e2e2e]">
                                    <td class="border border-gray-700 px-4 py-2 font-semibold">
                                        <label>
                                            <input type="checkbox" wire:model="selectedModulos" value="{{ $modulo->id_modulos }}" />
                                            {{ $modulo->nombre }}
                                        </label>
                                    </td>
                                    @foreach ($permisos as $permiso)
                                        <td class="border border-gray-700 px-4 py-2 text-center">
                                            <input type="checkbox"
                                                wire:model="selectedPermisos.{{$modulo->id_modulos}}.{{$permiso->id_permisos}}"
                                                wire:key="{{ $modulo->id_modulos }}-{{ $permiso->id_permisos }}" />
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Botones al final -->
                <div class="mt-6 flex justify-end space-x-4">
                    <a href="{{ route('roles.index') }}"
                        class="px-4 py-2 bg-gray-600 text-white font-bold rounded-lg shadow hover:bg-gray-700">
                        Cancelar
                    </a>

                    <button type="submit"
                        wire:click.prevent="saveRole"
                        class="px-4 py-2 bg-blue-600 text-white font-bold rounded-lg shadow hover:bg-blue-700">
                        Guardar Rol
                    </button>
                </div>

                <div wire:loading wire:target="saveRole" class="text-blue-400 font-bold text-center mt-3">
                    Guardando rol, por favor espera...
                </div>
            </div>
        </div>
    </div>
</div>
