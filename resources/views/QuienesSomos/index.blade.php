<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXFIT - Quiénes Somos</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-white">
    <!-- Header -->
    <header class="bg-black bg-opacity-90 fixed w-full z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 w-auto">
            </a>
            <div class="hidden md:flex space-x-8 text-sm">
                <a href="{{ url('/') }}" class="text-white hover:text-yellow-500 transition">INICIO</a>
                <a href="#" class="text-yellow-500 font-semibold">QUIÉNES SOMOS</a>
                <a href="{{ route('contacto') }}" class="text-white hover:text-yellow-500 transition">CONTACTO</a>
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-500 transition">INICIAR SESIÓN</a>
                <a href="{{ route('register') }}" class="text-white hover:text-yellow-500 transition">REGISTRARSE</a>
            </div>
        </nav>
    </header>

    <!-- Contenido principal -->
    <section class="px-6 bg-black min-h-screen">
        <div class="container flex flex-col justify-center items-start mx-auto gap-12 h-screen max-w-7xl">
            <h1 class="text-5xl font-bold mb-6 text-yellow-500">¿Quiénes Somos?</h1>
            <div class="flex justify-center items-center gap-24">
                <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo" class="w-[200px] h-[180px] border-white border-2 rounded-lg">
                <article>
                    <p class="text-lg text-gray-300 leading-8 mb-6">
                    En <strong>MAXFIT</strong> creemos que entrenar no es solo levantar peso o transpirar: es un estilo de vida. 
                    Nacimos con la misión de ofrecer un espacio donde cualquier persona (principiante o atleta avanzado)
                        pueda superarse, aprender y sentirse parte de una comunidad que empuja para adelante.
                    </p>
                    <p class="text-lg text-gray-300 leading-8 mb-6">
                        Nos especializamos en clases dinámicas, rutinas personalizadas y un seguimiento constante por parte de nuestros instructores. 
                        Nuestra infraestructura y tecnología están pensadas para ayudarte a lograr tus objetivos de forma saludable y sostenible.
                    </p>
                    <p class="text-lg text-gray-300 leading-8 mb-6">
                        Ya sea que busques transformar tu cuerpo, mejorar tu salud o simplemente encontrar un lugar donde descargar energía, 
                        en MAXFIT tenés tu lugar.
                </p>
                </article>
            </div>
            <div class="mt-10">
                <a href="{{ route('register') }}" class="bg-yellow-500 text-black px-8 py-3 rounded font-semibold hover:bg-yellow-400 transition">
                    Unite a la familia MAXFIT
                </a>
            </div>
        </div>
    </section>

    <!-- Nuestros valores -->
    <section class="bg-[#1a1a1a] py-16 px-6 mb-24">
        <div class="container mx-auto max-w-7xl">
            <div class="mb-20">
                <h2 class="text-4xl font-bold text-yellow-500 text-center mb-4">Nuestros valores</h2>
                <hr class="w-1/2 mx-auto border-yellow-500">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center text-gray-300">
                <div class="bg-[#2f2f2f] p-12 border-2 rounded-xl text-center transition-all scale-100 hover:scale-105">
                    <svg class="w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m10.051 8.102-3.778.322-1.994 1.994a.94.94 0 0 0 .533 1.6l2.698.316m8.39 1.617-.322 3.78-1.994 1.994a.94.94 0 0 1-1.595-.533l-.4-2.652m8.166-11.174a1.366 1.366 0 0 0-1.12-1.12c-1.616-.279-4.906-.623-6.38.853-1.671 1.672-5.211 8.015-6.31 10.023a.932.932 0 0 0 .162 1.111l.828.835.833.832a.932.932 0 0 0 1.111.163c2.008-1.102 8.35-4.642 10.021-6.312 1.475-1.478 1.133-4.77.855-6.385Zm-2.961 3.722a1.88 1.88 0 1 1-3.76 0 1.88 1.88 0 0 1 3.76 0Z"/>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Compromiso</h3>
                    <p>Estamos con vos en cada paso, en cada repetición, en cada logro.</p>
                </div>

                <div class="bg-[#2f2f2f] p-12 border-2 rounded-xl text-center transition-all scale-100 hover:scale-105">
                    <svg class="w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m4 12 8-8 8 8M6 10.5V19a1 1 0 0 0 1 1h3v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h3a1 1 0 0 0 1-1v-8.5"/>
                    </svg>

                    <h3 class="text-xl font-semibold mb-2">Comunidad</h3>
                    <p>Somos un espacio de encuentro, apoyo y buena energía. Acá nadie entrena solo.</p>
                </div>

                <div class="bg-[#2f2f2f] p-12 border-2 rounded-xl text-center transition-all scale-100 hover:scale-105">
                    <svg class="w-12 h-12 text-yellow-500 mx-auto mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v15a1 1 0 0 0 1 1h15M8 16l2.5-5.5 3 3L17.273 7 20 9.667"/>
                    </svg>
                    <h3 class="text-xl font-semibold mb-2">Superación</h3>
                    <p>No importa de dónde arrancás, importa hasta dónde querés llegar.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonios -->
    <section class="bg-black py-20 px-6 mb-24">
        <div class="container mx-auto max-w-7xl">
            <div class="mb-20">
                <h2 class="text-4xl font-bold text-yellow-500 text-center mb-4">Lo que dicen de nosotros</h2>
                <hr class="w-1/2 mx-auto border-yellow-500">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-gray-300">
                <div class="bg-[#1a1a1a] p-6 rounded-lg shadow-md">
                    <p class="italic">"MAXFIT me devolvió las ganas de entrenar. No es solo el lugar, es la energía que se vive acá."</p>
                    <p class="mt-4 font-semibold text-yellow-500">— Florencia G.</p>
                </div>
                <div class="bg-[#1a1a1a] p-6 rounded-lg shadow-md">
                    <p class="italic">"Empecé con 0 estado físico y hoy tengo mi rutina personalizada. Los profes son cracks."</p>
                    <p class="mt-4 font-semibold text-yellow-500">— Leandro M.</p>
                </div>
                <div class="bg-[#1a1a1a] p-6 rounded-lg shadow-md">
                    <p class="italic">"No es solo un gym. Es una comunidad donde te sentís parte desde el día uno."</p>
                    <p class="mt-4 font-semibold text-yellow-500">— Camila T.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <footer class="bg-[#121212] py-12">
        <div class="container mx-auto px-6 text-center text-gray-400">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 mx-auto mb-4">
            <div class="space-x-6">
                <a href="{{ url('/') }}" class="hover:text-white">Inicio</a>
                <a href="#" class="hover:text-white">Quiénes Somos</a>
                <a href="{{ route('contacto') }}" class="hover:text-white">Contacto</a>
            </div>
            <p class="mt-4">&copy; {{ date('Y') }} MAXFIT. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>
