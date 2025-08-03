<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mis Rutinas
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

                    <table class="mt-4 w-full border-collapse border border-gray-300">
                        <thead>
                            <tr class="bg-gray-200">
                                <th class="border border-gray-300 px-4 py-2">Asignado por instructor</th>
                                <th class="border border-gray-300 px-4 py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rutinas as $rutina)
                            <tr class="border border-gray-300">
                                <td class="px-4 py-2">
                                    {{ $rutina->asignador->name ?? '—' }}
                                </td>
                                <td class="px-4 py-2 flex justify-center items-center space-x-2">
                                    <!-- Botón para abrir el modal -->
                                    <button type="button"
                                        class="px-4 py-2 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600"
                                        onclick="document.getElementById('modal-{{ $rutina->id }}').showModal()">
                                        Ver
                                    </button>

                                    <!-- Modal -->
                                    <dialog id="modal-{{ $rutina->id }}" class="rounded-lg shadow-lg w-full max-w-md overflow-y-auto max-h-[80vh]">
                                        <div class="p-6">
                                            <h3 class="text-lg font-semibold mb-4">Rutina asignada</h3>
                                            <p class="text-gray-700 whitespace-pre-line">{{ $rutina->descripcion }}</p>
                                            <hr class="my-4">
                                            <p><strong>Asignada por:</strong> {{ $rutina->asignador->name ?? '—' }}</p>
                                            <div class="mt-4 text-right">
                                                <button onclick="document.getElementById('modal-{{ $rutina->id }}').close()"
                                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                                                    Cerrar
                                                </button>
                                            </div>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if(method_exists($rutinas, 'links'))
                    <div class="mt-4">
                        {{ $rutinas->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($rutinas->hasPages())
    <div class="mt-6 flex justify-center bg-gray-100 p-4 rounded shadow">
        {{ $rutinas->links() }}
    </div>
    @endif
</x-app-layout>