<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        event(new Registered($user = User::create($validated)));

        // Asignar el rol por defecto
        $rol = \App\Models\Rol::where('nombre', 'Cliente')->first();
        if ($rol) {
            $user->rol()->attach($rol->id_roles);
        }

        Auth::login($user);
        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-cover bg-center relative" 
     style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7)), url('{{ asset('images/register.png') }}');">
    
    <!-- Header Navigation -->
    <header class="absolute top-0 w-full z-50">
        <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
            {{-- Logo --}}
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 w-auto">
        </a>
            <div class="hidden md:flex space-x-8 text-sm">
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-yellow-500 transition">INICIO</a>
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-yellow-500 transition" wire:navigate>INICIAR SESIÓN</a>
                <a href="{{ route('register') }}" class="text-yellow-500 font-semibold">REGISTRARSE</a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20">
        <div class="container mx-auto px-6">
                
                <!-- Form Section -->
                <div class="max-w-xl mx-auto ">
                    <div class="bg-[#212121]/73 backdrop-blur-sm rounded-2xl p-8 lg:p-10">
                        
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">
                                Bienvenido, forma<br>
                                parte ahora 💪
                            </h1>
                            <p class="text-gray-300 text-base">
                                Regístrate ahora para entrenar a alto nivel con nosotros
                            </p>
                        </div>

                        <!-- Registration Form -->
                        <form wire:submit="register" class="space-y-6">
                            
                            <!-- Name Field -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input wire:model="name" 
                                           type="text" 
                                           placeholder="Nombre de usuario"
                                           class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('name') border-red-500 @enderror">
                                </div>
                                @error('name') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    <input wire:model="email" 
                                           type="email" 
                                           placeholder="nombre@gmail.com"
                                           class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('email') border-red-500 @enderror">
                                </div>
                                @error('email') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Password Field -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input wire:model="password" 
                                           type="password" 
                                           placeholder="Contraseña"
                                           class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('password') border-red-500 @enderror">
                                </div>
                                @error('password') 
                                    <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                                @enderror
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="relative">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <input wire:model="password_confirmation" 
                                           type="password" 
                                           placeholder="Confirmar contraseña"
                                           class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors">
                                </div>
                            </div>

                            <!-- Register Button -->
                            <div class="pt-4">
                                <button type="submit" 
                                        class="w-full bg-[#FFCC00] hover:bg-gray-900 text-black font-semibold py-4 rounded-lg transition-colors duration-300"
                                        wire:loading.attr="disabled"
                                        wire:loading.class="opacity-50 cursor-not-allowed">
                                    <span wire:loading.remove>Regístrate</span>
                                    <span wire:loading>Registrando...</span>
                                </button>
                            </div>
                        </form>

                        <!-- Terms and Login Link -->
                        <div class="mt-6 text-center">
                            <p class="text-gray-400 text-sm mb-3">
                                Al registrarte aceptas nuestros 
                                <a href="#" class="text-yellow-500 hover:underline">Términos y Condiciones</a>
                            </p>
                            <p class="text-gray-400 text-sm">
                                ¿Ya tienes cuenta? 
                                <a href="{{ route('login') }}" class="text-yellow-500 hover:underline" wire:navigate>Inicia sesión</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Image Section (Hidden on mobile) -->
                <div class="hidden lg:block">
                    <!-- This space is for the background image that shows on the right -->
                </div>
            </div>
        </div>
</div>