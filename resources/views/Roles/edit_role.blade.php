<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Actualizar Rol
        </h2>
    </x-slot>

    <div class="py-4 bg-[#121212] min-h-screen text-white">
        <livewire:roles.edit :rolId="$rol->id_roles" />
    </div>
</x-app-layout>
