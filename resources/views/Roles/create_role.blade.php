<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Crear Nuevo Rol
        </h2>
    </x-slot>

    <div class="py-12 bg-[#121212] min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#232323] shadow-md sm:rounded-lg">
                <div class="p-6 text-white">
                    <livewire:roles.create />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
