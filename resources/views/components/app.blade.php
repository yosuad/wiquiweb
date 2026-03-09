<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Meta Data-->
    <meta charset="UTF-8">
    <meta name="description"
        content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | @yield('title', 'Inicio')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P3VQQCCJC6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "G-P3VQQCCJC6");
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])     
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</head>

<body>

    <!-- START PRELOADER -->
    <div class="preloader" id="preloader">
        <div id="preloader__animation" style="width: 150px; height: 150px;"></div>
    </div>
    <!-- END PRELOADER -->

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- Contenido principal --}}
    <main class="dashboard-content">
        @yield('content')
    </main>

    <!-- ═══════════════ FOOTER ═══════════════ -->
    <footer class="footer">
        <div class="container">
            <div class="footer__main">
                <div class="footer__newsletter">
                    <h2>¡Contáctanos!</h2>
                    <p>¡Gracias por tu interés en mantenerte informado sobre nuestras ofertas, nuevas tecnologías y
                        desarrollos web! Si deseas recibir actualizaciones y contenido exclusivo, déjanos tu correo
                        electrónico:</p>
                    <form class="footer__form">
                        <div class="footer__input-wrapper">
                            <i data-lucide="mail" class="footer__input-icon"></i>
                            <input type="email" placeholder="Correo Electrónico" class="footer__input" required>
                        </div>
                        <button type="submit" class="btn-primary"
                            style="padding:1rem 2rem;display:flex;align-items:center;gap:0.5rem;">
                            <span style="display:none;">Suscríbete</span>
                            <i data-lucide="send" style="width:20px;height:20px;"></i>
                        </button>
                    </form>
                </div>

                <div class="footer__links">
                    <div>
                        <h3>Servicios</h3>
                        <ul>
                            <li><a href="#">Diseño web</a></li>
                            <li><a href="#">Actualizaciones</a></li>
                            <li><a href="#">Correos corporativos</a></li>
                            <li><a href="#">Creación contenido</a></li>
                            <li><a href="#">Campañas</a></li>
                            <li><a href="#">Capacitaciones</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3>Recursos</h3>
                        <ul>
                            <li><a href="#">Blog</a></li>
                            <li><a href="#">Formación</a></li>
                            <li><a href="#">Portafolio</a></li>
                            <li><a href="#">Marketing</a></li>
                            <li><a href="#">Consultoría</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3>Soporte</h3>
                        <ul>
                            <li><a href="#">Contacto</a></li>
                            <li><a href="#">Política de privacidad</a></li>
                            <li><a href="#">Términos de uso</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <p>© 2024. Todos los derechos reservados wiquiweb</p>
                <div class="footer__bottom-links">
                    <a href="{{ route('privacy') }}">Política de privacidad</a>
                    <a href="#">Términos de uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ═══════════════ WHATSAPP BUTTON ═══════════════ -->
    <a href="https://api.whatsapp.com/send?phone=+573506396283&text=Me%20interesan%20sus%20servicios%20y%20me%20gustar%C3%ADa%20obtener%20m%C3%A1s%20informaci%C3%B3n."
        target="_blank" rel="noopener noreferrer" class="whatsapp-btn" aria-label="Contactar por WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="white"
            stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path
                d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z" />
        </svg>
    </a>

    <!-- PRELOADER -- MENU MOBILE -->
    <script src="{{ asset('js/main.js') }}"></script>

</body>

</html>
