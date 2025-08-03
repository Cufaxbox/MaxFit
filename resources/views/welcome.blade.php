<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXFIT - Entrena a Alto Nivel</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <a href="{{ route('quienes-somos') }}" class="text-white hover:text-yellow-500 transition">QUIÉNES SOMOS</a>
            <a href="{{ route('contacto') }}" class="text-white hover:text-yellow-500 transition">CONTACTO</a>
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
    <section class="py-20 bg-[#121212]">
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
    <footer class="bg-[#121212] py-12">
        <div class="container mx-auto px-6 text-center text-gray-400">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 mx-auto mb-4">
            <div class="space-x-6">
                <a href="#" class="hover:text-white">Inicio</a>
                <a href="{{ route('quienes-somos') }}" class="hover:text-white">Quiénes Somos</a>
                <a href="{{ route('contacto') }}" class="hover:text-white">Contacto</a>
            </div>
            <p class="mt-4">&copy; {{ date('Y') }} MAXFIT. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>