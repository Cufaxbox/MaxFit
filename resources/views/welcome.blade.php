<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MA FIT - Entrena a Alto Nivel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .hero-bg {
            background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7)), url('{{ asset("images/banner-ppl.png") }}');
            background-size: cover;
            background-position: center;
        }
        .exercise-card {
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .exercise-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0.7));
        }
    </style>
</head>
<body class="bg-black text-white">
    <!-- Header -->
    <header class="bg-black bg-opacity-90 fixed w-full z-50">
    <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="/" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 w-auto">
        </a>

        {{-- Menú de navegación --}}
        <div class="hidden md:flex space-x-8 text-sm">
            <a href="#" class="text-yellow-500 font-semibold">INICIO</a>
            <a href="{{ route('login') }}" class="text-white hover:text-yellow-500 transition">INICIAR SESIÓN</a>
            <a href="{{ route('register') }}" class="text-white hover:text-yellow-500 transition">REGISTRARSE</a>
        </div>
    </nav>
</header>

    <!-- Hero Section -->
    <section class="hero-bg min-h-screen flex items-center pt-20">
        <div class="container mx-auto px-6">
            <div class="max-w-2xl">
                <h1 class="text-6xl md:text-8xl font-bold mb-6">
                    <span class="text-yellow-500">ENTRENA</span><br>
                    <span class="text-white">A ALTO NIVEL</span>
                </h1>
                <p class="text-xl mb-8 text-gray-300">
                    Transforma tu cuerpo, domina tu rutina.<br>
                    Vive la experiencia del alto rendimiento, entrena con<br>
                    clases, explora actividades y lleva el control total de tus progresos.
                </p>
                <div class="flex space-x-4">
                    <a href="/" class="bg-yellow-500 text-black px-8 py-3 rounded font-semibold hover:bg-yellow-400 transition">
                        Agendá tu turno
                    </a>
                    <a href="/" class="border border-white text-white px-8 py-3 rounded hover:bg-white hover:text-black transition">
                        Calendario
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Ejercicios Disponibles -->
    <section class="py-20 bg-gray-900">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-4xl font-bold">Ejercicios disponibles</h2>
                <a href="#" class="text-yellow-500 hover:underline">Ver más ejercicios</a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/natacion.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">Natación</h3>
                        <p class="text-gray-300">Lunes, martes y jueves</p>
                    </div>
                </div>
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/kickboxing.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">Kickboxing</h3>
                        <p class="text-gray-300">Lunes, miércoles y viernes</p>
                    </div>
                </div>
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/hiit.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">HIIT</h3>
                        <p class="text-gray-300">Lunes, jueves y viernes</p>
                    </div>
                </div>
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/zumba.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">Zumba</h3>
                        <p class="text-gray-300">Miércoles y viernes</p>
                    </div>
                </div>
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/crossfit.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">Crossfit</h3>
                        <p class="text-gray-300">Lunes y sábado</p>
                    </div>
                </div>
                <div class="exercise-card h-64 rounded-lg overflow-hidden relative" style="background-position: center; background-repeat: no-repeat; background-size: cover; background-image: url('{{ asset('images/musculacion.png') }}'">
                    <div class="absolute bottom-0 left-0 p-6 z-10">
                        <h3 class="text-2xl font-bold mb-2">Musculación</h3>
                        <p class="text-gray-300">Martes y jueves</p>
                    </div>
                </div>
            </div>
    </section>

    <!-- Entrená a tu ritmo -->
    <section class="py-20 bg-black">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <h2 class="text-5xl md:text-6xl font-bold mb-8">
                        Entrená<br>
                        a tu ritmo.<br>
                        <span class="text-yellow-500">Agendá<br>
                        un turno.</span>
                    </h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <img src="{{ asset('images/calistenia.png') }}" alt="Entrenamiento" class="rounded-lg">
                    <img src="{{ asset('images/trx.png') }}" alt="Entrenamiento" class="rounded-lg">
                    <img src="{{ asset('images/strong.png') }}" alt="Entrenamiento" class="rounded-lg col-span-2">
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 py-12">
        <div class="container mx-auto px-6">
            <div class="text-center mb-8">
                <div class="text-2xl font-bold mb-4">
                    <span class="text-white">MA</span>
                    <span class="text-yellow-500">FIT</span>
                </div>
            </div>
            <div class="flex justify-center space-x-8 mb-8">
                <a href="#" class="text-gray-400 hover:text-white transition">Inicio</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Políticas de privacidad</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Defensa al consumidor</a>
                <a href="#" class="text-gray-400 hover:text-white transition">Contacto</a>
            </div>
            <div class="flex justify-center space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001.012.001z.017 0z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>
</body>
</html>