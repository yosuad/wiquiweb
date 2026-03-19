<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | @yield('title', 'Inicio')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P3VQQCCJC6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag("js", new Date());
        gtag("config", "G-P3VQQCCJC6");
    </script>

    {{-- Vite — CSS y JS compilados --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Scripts locales --}}
    <script src="{{ asset('js/lottie.min.js') }}"></script>
    <script src="{{ asset('js/lucide.min.js') }}"></script>

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

    {{-- Lucide — inicializa íconos --}}
    <script>lucide.createIcons();</script>

    @stack('scripts')

</body>

</html>