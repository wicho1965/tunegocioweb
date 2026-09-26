<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TuNegocioWeb — Catálogo digital y pedidos por WhatsApp</title>
    <meta name="description" content="Crea tu catálogo digital, compártelo con QR y recibe pedidos por WhatsApp.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Aplicar tema guardado antes de pintar la página
        if (localStorage.getItem('landing-theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    {{-- Navbar --}}
    <nav
        class="fixed top-0 inset-x-0 z-50 bg-white/95 dark:bg-gray-900/95 backdrop-blur border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-lg shrink-0">
                <span
                    class="h-8 w-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm">TN</span>
                <span class="text-gray-900 dark:text-white">TuNegocioWeb</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Idioma --}}
                <div class="flex items-center gap-1">
                    <a href="{{ route('locale.switch', 'es') }}"
                        class="px-2 py-1 rounded text-xs font-bold transition
                       {{ app()->getLocale() === 'es' ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        ES
                    </a>
                    <a href="{{ route('locale.switch', 'en') }}"
                        class="px-2 py-1 rounded text-xs font-bold transition
                       {{ app()->getLocale() === 'en' ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800' }}">
                        EN
                    </a>
                </div>

                {{-- Dark mode (JS puro) --}}
                <button type="button" id="theme-toggle"
                    class="p-2 rounded-lg text-gray-500 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 transition"
                    title="Cambiar tema">
                    {{-- Sol (se muestra en dark) --}}
                    <svg id="icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    {{-- Luna (se muestra en light) --}}
                    <svg id="icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                </button>

                @auth
                    <a href="{{ route('dashboard') }}"
                        class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white px-2">
                        {{ __('Ingresar') }}
                    </a>
                    <a href="{{ route('register') }}"
                        class="text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl">
                        {{ __('Registrarse') }}
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section
        class="pt-28 pb-16 sm:pt-32 sm:pb-24 bg-gradient-to-b from-indigo-50 to-white dark:from-gray-800 dark:to-gray-900">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
            <h1
                class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 dark:text-white max-w-3xl mx-auto leading-tight">
                {{ __('Digitalizá tu negocio y recibí pedidos por WhatsApp') }}
            </h1>

            <p class="mt-6 text-lg text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                {{ __('Creá tu catálogo online, compartilo con un código QR y dejá que tus clientes te pidan directo al chat. Simple, rápido y sin complicaciones.') }}
            </p>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('register') }}"
                    class="inline-flex justify-center items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3.5 rounded-2xl shadow-lg shadow-indigo-200 dark:shadow-none transition">
                    {{ __('Crear mi tienda gratis') }}
                </a>
                <a href="{{ url('/mi-tienda-demo') }}" target="_blank"
                    class="inline-flex justify-center items-center bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100 font-semibold px-6 py-3.5 rounded-2xl transition">
                    {{ __('Ver demo del catálogo') }}
                </a>
            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                {{ __('Sin tarjeta de crédito · Empezás en minutos') }}
            </p>
        </div>
    </section>

    {{-- Cómo funciona --}}
    <section class="py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Cómo funciona') }}</h2>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('En 4 pasos tenés tu negocio digital listo') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div
                        class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold mb-4">
                        1</div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Creá tu tienda') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Registrate y configurá nombre, WhatsApp y datos de tu negocio.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div
                        class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold mb-4">
                        2</div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Cargá productos') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Agregá categorías, precios y descripciones desde el panel.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div
                        class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold mb-4">
                        3</div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Compartí tu QR') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Generamos un código QR único para que tus clientes entren al catálogo.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6 shadow-sm">
                    <div
                        class="h-10 w-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-bold mb-4">
                        4</div>
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Recibí pedidos') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('El cliente arma el pedido y te llega todo armado por WhatsApp.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Características --}}
    <section class="py-16 sm:py-20 bg-gray-50 dark:bg-gray-800/50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Todo lo que necesitás') }}</h2>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('Pensado para comercios reales') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Catálogo digital') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Productos organizados por categorías, con buscador y diseño moderno.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Pedidos por WhatsApp') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('El cliente confirma y te escribe directo al chat con el detalle del pedido.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Código QR') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Ideal para mesas, vidrieras, redes y material impreso.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Panel del comerciante') }}
                    </h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Administrá productos, categorías y datos de tu tienda fácilmente.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Modo oscuro') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Dashboard y catálogo adaptados para usar de día o de noche.') }}</p>
                </div>
                <div
                    class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-sm">
                    <h3 class="font-semibold text-lg text-gray-900 dark:text-white">{{ __('Multi-idioma') }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Interfaz en español e inglés para vos y tus clientes.') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Precios --}}
    <section class="py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Plan simple y transparente') }}
                </h2>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('Sin contratos. Cancelás cuando quieras.') }}
                </p>
            </div>

            <div class="max-w-lg mx-auto">
                <div class="bg-white dark:bg-gray-800 border-2 border-indigo-600 rounded-3xl p-8 shadow-xl relative">
                    <div
                        class="absolute -top-3 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ __('Todo incluido') }}
                    </div>

                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Plan Completo') }}</h3>
                        <div class="mt-4 flex items-end justify-center gap-1">
                            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">$15.000</span>
                            <span class="text-gray-500 dark:text-gray-400 mb-1">/ {{ __('mes') }}</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Pesos argentinos · 7 días de prueba gratis') }}</p>
                    </div>

                    <ul class="mt-8 space-y-3 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Catálogo digital con QR') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Productos y categorías ilimitados') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Pedidos por WhatsApp') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Panel de administración') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Modo oscuro y multi-idioma') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Soporte por WhatsApp') }}
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="mt-8 w-full inline-flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3.5 rounded-2xl transition">
                        {{ __('Empezar prueba gratis') }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    {{-- Precios --}}
    <section class="py-16 sm:py-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Plan simple y transparente') }}
                </h2>
                <p class="mt-3 text-gray-600 dark:text-gray-400">{{ __('Sin contratos. Cancelás cuando quieras.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">

                {{-- Plan Gratis --}}
                <div
                    class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-3xl p-8 shadow-sm">
                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Plan Gratis') }}</h3>
                        <div class="mt-4 flex items-end justify-center gap-1">
                            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">$0</span>
                            <span class="text-gray-500 dark:text-gray-400 mb-1">/ {{ __('mes') }}</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Ideal para probar la plataforma') }}
                        </p>
                    </div>

                    <ul class="mt-8 space-y-3 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('1 tienda') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Hasta 20 productos') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Catálogo digital con QR') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Pedidos por WhatsApp') }}
                        </li>
                        <li class="flex items-center gap-2 text-gray-400">
                            <span class="font-bold">−</span>
                            {{ __('Soporte prioritario') }}
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="mt-8 w-full inline-flex justify-center bg-gray-900 dark:bg-gray-700 hover:bg-black dark:hover:bg-gray-600 text-white font-semibold px-6 py-3.5 rounded-2xl transition">
                        {{ __('Empezar gratis') }}
                    </a>
                </div>

                {{-- Plan Pro --}}
                <div class="bg-white dark:bg-gray-800 border-2 border-indigo-600 rounded-3xl p-8 shadow-xl relative">
                    <div
                        class="absolute -top-3 left-1/2 -translate-x-1/2 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        {{ __('Recomendado') }}
                    </div>

                    <div class="text-center">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Plan Pro') }}</h3>
                        <div class="mt-4 flex items-end justify-center gap-1">
                            <span class="text-4xl font-extrabold text-gray-900 dark:text-white">$15.000</span>
                            <span class="text-gray-500 dark:text-gray-400 mb-1">/ {{ __('mes') }}</span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('Pesos argentinos · 7 días de prueba gratis') }}
                        </p>
                    </div>

                    <ul class="mt-8 space-y-3 text-sm text-gray-700 dark:text-gray-300">
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Productos y categorías ilimitados') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Catálogo digital con QR') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Pedidos por WhatsApp') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Panel de administración') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Modo oscuro y multi-idioma') }}
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-green-500 font-bold">✓</span>
                            {{ __('Soporte por WhatsApp') }}
                        </li>
                    </ul>

                    <a href="{{ route('register') }}"
                        class="mt-8 w-full inline-flex justify-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3.5 rounded-2xl transition">
                        {{ __('Empezar prueba gratis') }}
                    </a>
                </div>

            </div>
        </div>
    </section>
    <section class="py-16 sm:py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center">
            <div class="bg-indigo-600 rounded-3xl px-6 py-12 sm:px-12 text-white shadow-xl">
                <h2 class="text-3xl font-bold">{{ __('Empezá hoy mismo') }}</h2>
                <p class="mt-3 text-indigo-100 max-w-xl mx-auto">
                    {{ __('Creá tu cuenta, configurá tu tienda y compartí tu catálogo en minutos.') }}
                </p>
                <a href="{{ route('register') }}"
                    class="mt-8 inline-flex bg-white text-indigo-700 hover:bg-indigo-50 font-semibold px-6 py-3.5 rounded-2xl transition">
                    {{ __('Crear mi tienda gratis') }}
                </a>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="border-t border-gray-100 dark:border-gray-800 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="text-center md:text-left">
                    <p class="font-semibold text-gray-900 dark:text-white">TuNegocioWeb</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        © {{ date('Y') }} TuNegocioWeb. {{ __('Todos los derechos reservados.') }}
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="https://instagram.com/" target="_blank" rel="noopener"
                        class="text-gray-400 hover:text-pink-500 transition" title="Instagram">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M7.75 2h8.5A5.75 5.75 0 0122 7.75v8.5A5.75 5.75 0 0116.25 22h-8.5A5.75 5.75 0 012 16.25v-8.5A5.75 5.75 0 017.75 2zm0 1.5A4.25 4.25 0 003.5 7.75v8.5A4.25 4.25 0 007.75 20.5h8.5a4.25 4.25 0 004.25-4.25v-8.5A4.25 4.25 0 0016.25 3.5h-8.5zM12 7a5 5 0 110 10 5 5 0 010-10zm0 1.5a3.5 3.5 0 100 7 3.5 3.5 0 000-7zm5.25-.88a1.12 1.12 0 110 2.24 1.12 1.12 0 010-2.24z" />
                        </svg>
                    </a>
                    <a href="https://facebook.com/" target="_blank" rel="noopener"
                        class="text-gray-400 hover:text-blue-600 transition" title="Facebook">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.9.3-1.5 1.6-1.5H16.5V5.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3V11H7.5v3h2.3v8h3.7z" />
                        </svg>
                    </a>
                    <a href="https://x.com/" target="_blank" rel="noopener"
                        class="text-gray-400 hover:text-gray-900 dark:hover:text-white transition" title="X">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <a href="https://wa.me/5491112345678" target="_blank" rel="noopener"
                        class="text-gray-400 hover:text-green-500 transition" title="WhatsApp">
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.435 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        (function() {
            const html = document.documentElement;
            const btn = document.getElementById('theme-toggle');
            const iconSun = document.getElementById('icon-sun');
            const iconMoon = document.getElementById('icon-moon');

            function syncIcons() {
                const isDark = html.classList.contains('dark');
                iconSun.classList.toggle('hidden', !isDark);
                iconMoon.classList.toggle('hidden', isDark);
            }

            syncIcons();

            btn.addEventListener('click', function() {
                html.classList.toggle('dark');
                localStorage.setItem(
                    'landing-theme',
                    html.classList.contains('dark') ? 'dark' : 'light'
                );
                syncIcons();
            });
        })();
    </script>
</body>

</html>
