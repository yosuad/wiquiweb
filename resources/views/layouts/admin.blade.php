<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | @yield('title', 'Inicio')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</head>

<body>

    {{-- PRELOADER --}}
    <div class="preloader" id="preloader">
        <div id="preloader__animation" style="width: 150px; height: 150px;"></div>
    </div>

    {{-- SIDEBAR --}}
    @include('components.sidebar')

    {{-- WRAPPER: header + contenido --}}
    <div class="dashboard__wrapper">

        {{-- HEADER --}}
        @include('components.navigation')

        {{-- CONTENIDO --}}
        <main class="dashboard__content">
            @yield('content')
        </main>

    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>