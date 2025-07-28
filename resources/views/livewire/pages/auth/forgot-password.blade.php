<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', 'Te hemos enviado un enlace de restablecimiento de contraseña por email.');
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
                <a href="{{ url('/') }}" class="text-gray-300 hover:text-yellow-500 transition">ACTIVIDADES</a>
                <a href="{{ route('login') }}" class="text-gray-300 hover:text-yellow-500 transition" wire:navigate>INICIAR SESIÓN</a>
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
                            ¿Olvidaste tu<br>
                            contraseña? 🔐
                        </h1>
                        <p class="text-gray-300 text-base">
                            No te preocupes, te enviaremos un enlace para restablecer tu contraseña
                        </p>
                    </div>

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="mb-6 p-4 bg-green-900/20 border border-green-500/20 rounded-lg">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-green-400 text-sm">{{ session('status') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Forgot Password Form -->
                    <form wire:submit="sendPasswordResetLink" class="space-y-6">
                        
                        <!-- Email Field -->
                        <div class="relative">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                                <input wire:model="email" 
                                       type="email" 
                                       id="email"
                                       name="email"
                                       placeholder="nombre@gmail.com"
                                       required
                                       autofocus
                                       class="w-full py-3 bg-transparent border-b-2 border-gray-600 text-white placeholder-gray-400 focus:border-yellow-500 focus:outline-none transition-colors @error('email') border-red-500 @enderror">
                            </div>
                            @error('email') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> 
                            @enderror
                        </div>

                        <!-- Send Reset Link Button -->
                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full bg-[#FFCC00] hover:bg-yellow-600 text-black font-semibold py-4 rounded-lg transition-colors duration-300"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed">
                                <span wire:loading.remove>Enviar enlace de restablecimiento</span>
                                <span wire:loading>Enviando...</span>
                            </button>
                        </div>
                    </form>

                    <!-- Back to Login -->
                    <div class="mt-8 text-center">
                        <p class="text-gray-400 text-sm">
                            ¿Recordaste tu contraseña? 
                            <a href="{{ route('login') }}" class="text-yellow-500 hover:underline" wire:navigate>Volver al inicio de sesión</a>
                        </p>
                    </div>

                    <!-- Additional Help -->
                    <div class="mt-6 p-4 bg-gray-800/50 rounded-lg border border-gray-700">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-500 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h3 class="text-white text-sm font-semibold mb-1">¿Necesitas ayuda?</h3>
                                <p class="text-gray-400 text-xs">
                                    Si no recibes el email en unos minutos, revisa tu carpeta de spam o contacta con nuestro soporte.
                                </p>
                            </div>
                        </div>
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