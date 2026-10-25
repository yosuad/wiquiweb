<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="wiquiweb">
    <title>wiquiweb | @yield('title', 'Inicio')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Meta para compartir (OG / Twitter) --}}
    @include('components.meta-compartir', [
        'titulo' => $metaTitulo ?? null,
        'descripcion' => $metaDescripcion ?? null,
        'imagen' => $metaImagen ?? null,
        'tipo' => $metaTipo ?? 'website',
    ])

    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P3VQQCCJC6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "G-P3VQQCCJC6");
    </script>

    {{-- Vite — CSS y JS compilados --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Scripts locales --}}
    <script src="{{ asset('js/lottie.min.js') }}"></script>

    @stack('styles')
</head>

<body>

    {{-- PRELOADER --}}
    <div class="preloader" id="preloader">
        <div id="preloader__animation" style="width: 150px; height: 150px;"></div>
    </div>

    {{-- NAVBAR --}}
    @include('components.navbar')

    {{-- CONTENIDO --}}
    <main class="home-content">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('components.footer')

    {{-- Scripts --}}
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')

</body>

</html>
