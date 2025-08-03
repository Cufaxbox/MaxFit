<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1e1e1e] overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-100">
                    <form action="{{ route('usuarios.update', ['usuario' => $usuario->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Nombre -->
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-300 mb-1">Nombre:</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $usuario->name) }}"
                                   class="w-full px-4 py-2 bg-zinc-900 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   required>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email:</label>
                            <input type="email" name="email" id="email"
                                   value="{{ old('email', $usuario->email) }}"
                                   class="w-full px-4 py-2 bg-zinc-900 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                   required>
                        </div>

                        <!-- Rol -->
                        <div class="mb-6">
                            <label for="rol_id" class="block text-sm font-medium text-gray-300 mb-1">Rol:</label>
                            <select name="rol_id" id="rol_id"
                                    class="w-full px-4 py-2 bg-zinc-900 border border-gray-700 rounded-md text-white focus:outline-none focus:ring-2 focus:ring-yellow-500"
                                    required>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id_roles }}"
                                        {{ $usuario->rol->contains($rol) ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Botones -->
                        <div class="flex items-center gap-4">

                        <a href="{{ route('usuarios.index') }}" wire:navigate
                               class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition font-medium">
                                Cancelar
                            </a>
                            
                            <button type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition font-medium">
                                Actualizar Usuario
                            </button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
