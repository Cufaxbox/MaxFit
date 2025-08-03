<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MAXFIT - Contacto</title>
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
                <a href="{{ route('quienes-somos') }}" class="text-white hover:text-yellow-500 transition">QUIÉNES SOMOS</a>
                <a href="#" class="text-yellow-500 font-semibold">CONTACTO</a>
                <a href="{{ route('login') }}" class="text-white hover:text-yellow-500 transition">INICIAR SESIÓN</a>
                <a href="{{ route('register') }}" class="text-white hover:text-yellow-500 transition">REGISTRARSE</a>
            </div>
        </nav>
    </header>

    <!-- Contacto -->
    <section class="px-6 bg-black min-h-screen py-44">
        <div class="container mx-auto max-w-7xl">
            <!-- Título y subtítulo -->
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-yellow-500 mb-4">¿Querés hablar con nosotros?</h1>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Ya sea para sumarte, hacer una consulta o simplemente decirnos algo… ¡estamos acá para escucharte!
                </p>
            </div>

            <!-- Formulario -->
            <div class="flex justify-center pt-8">
                <aside class="bg-[#1a1a1a] rounded-2xl p-12 flex flex-col justify-center items-center gap-12 w-full max-w-2xl shadow-xl border border-[#333]">
                    <div class="flex justify-start items-center gap-4 mb-4 w-full">
                        <svg class="w-10 h-10 text-yellow-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25v-1.5a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6.75v10.5A2.25 2.25 0 0 0 5.25 19.5h13.5A2.25 2.25 0 0 0 21 17.25v-1.5m0-7.5L12 14.25 3 8.25" />
                        </svg>
                        <h2 class="text-3xl font-bold text-yellow-500">Formulario de contacto</h2>
                    </div>
                    <form onsubmit="mostrarMensaje(event)" class="space-y-6 w-full">
                        <div>
                            <label for="nombre" class="block mb-2 font-semibold">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="w-full px-4 py-2 bg-black border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label for="apellido" class="block mb-2 font-semibold">Apellido</label>
                            <input type="text" id="apellido" name="apellido" class="w-full px-4 py-2 bg-black border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500">
                        </div>
                        <div>
                            <label for="consulta" class="block mb-2 font-semibold">Consulta</label>
                            <textarea id="consulta" name="consulta" rows="4" class="w-full px-4 py-2 bg-black border border-gray-600 rounded focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
                        </div>
                        <div class="text-left">
                            <button type="submit" class="bg-yellow-500 text-black px-6 py-2 rounded font-semibold hover:bg-yellow-400 transition">
                                Enviar
                            </button>
                        </div>
                    </form>
                </aside>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#121212] py-12">
        <div class="container mx-auto px-6 text-center text-gray-400">
            <img src="{{ asset('images/logo-maxfit.png') }}" alt="Logo MA FIT" class="h-10 mx-auto mb-4">
            <div class="space-x-6">
                <a href="{{ url('/') }}" class="hover:text-white">Inicio</a>
                <a href="{{ route('quienes-somos') }}" class="hover:text-white">Quiénes Somos</a>
                <a href="#" class="hover:text-white">Contacto</a>
            </div>
            <p class="mt-4">&copy; {{ date('Y') }} MAXFIT. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
<!-- Sweet alert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function mostrarMensaje(event) {
        event.preventDefault();

        const nombre = document.getElementById('nombre').value.trim();
        const apellido = document.getElementById('apellido').value.trim();
        const consulta = document.getElementById('consulta').value.trim();

        if (!nombre || !apellido || !consulta) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor completá todos los campos antes de enviar.',
                confirmButtonColor: '#facc15',
                background: '#1a1a1a',
                color: '#fff'
            });
            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Consulta enviada',
            text: 'Gracias por contactarte con nosotros. ¡Te responderemos a la brevedad!',
            confirmButtonColor: '#facc15',
            background: '#1a1a1a',
            color: '#fff'
        });

        // Opcional: limpiar el formulario
        event.target.reset();
    }
</script>


</html>
