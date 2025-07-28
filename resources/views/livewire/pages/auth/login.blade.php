<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="min-h-screen bg-cover bg-center relative" 
     style="background-image: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7)), url('{{ asset('images/login.png') }}');">
    
    <!-- Header Navigation -->
    <header class="absolute top-0 w-full z-50">
        <nav class="container mx-auto px-6 py-6 flex justify-between items-center">
            {{-- Logo --}}
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 w-auto">
        </a>
            <div class="hidden md:flex space-x-8 text-sm">
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-yellow-500 transition">INICIO</a>
                <a href="{{ route('login') }}" class="text-yellow-500 font-semibold">INICIAR SESIÓN</a>
                <a href="{{ route('register') }}" class="text-gray-300 hover:text-yellow-500 transition" wire:navigate>REGISTRARSE</a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <div class="min-h-screen flex items-center justify-center pt-20">
        <div class="container mx-auto px-6">
            
            <!-- Form Section -->
            <div class="max-w-xl mx-auto">
                <div class="bg-[#212121]/73 backdrop-blur-sm rounded-2xl p-8 lg:p-10">
                    
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <h1 class="text-3xl lg:text-4xl font-bold text-white mb-4 leading-tight">
                            Bienvenido<br>
                            de vuelta 👋
                        </h1>
                        <p class="text-gray-300 text-base">
                            Inicia sesión para continuar entrenando a alto nivel
                        </p>
                    </div>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Login Form -->
                    <form wire:submit="login" class="space-y-6">
                        
                        <!-- Email Field -->
                        <div class="relative">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                <input wire:model="form.email" 
                                       type="email" 
                                       id="email"
                                       name="email"
                                       placeholder="nombre@gmail.com"
                                       required
                                       autofocus
                                       autocomplete="username"
                                       class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('form.email') border-red-500 @enderror">
                            </div>
                            @error('form.email') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="relative">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                                <input wire:model="form.password" 
                                       type="password" 
                                       id="password"
                                       name="password"
                                       placeholder="Contraseña"
                                       required
                                       autocomplete="current-password"
                                       class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('form.password') border-red-500 @enderror">
                            </div>
                            @error('form.password') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input wire:model="form.remember" 
                                       id="remember"
                                       name="remember"
                                       type="checkbox" 
                                       class="rounded border-gray-600 bg-gray-700 text-yellow-500 shadow-sm focus:ring-yellow-500 focus:ring-offset-gray-800">
                                <span class="ml-2 text-sm text-gray-300">Recordarme</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-yellow-500 hover:underline" 
                                   href="{{ route('password.request') }}" 
                                   wire:navigate>
                                    ¿Olvidaste tu contraseña?
                                </a>
                            @endif
                        </div>

                        <!-- Login Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-[#FFCC00] hover:bg-yellow-600 text-black font-semibold py-4 rounded-lg transition-colors duration-300"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed">
                                <span wire:loading.remove>Iniciar Sesión</span>
                                <span wire:loading>Iniciando sesión...</span>
                            </button>
                        </div>
                    </form>

                    <!-- Register Link -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-400 text-sm">
                            ¿No tienes cuenta? 
                            <a href="{{ route('register') }}" class="text-yellow-500 hover:underline" wire:navigate>Regístrate aquí</a>
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