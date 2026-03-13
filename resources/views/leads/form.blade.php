<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | Contáctanos</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    @vite(['resources/css/leads/form.css', 'resources/js/app.js'])
    <script src="{{ asset('js/lottie.min.js') }}"></script>
</head>

<body class="page-form">

    {{-- PRELOADER --}}
    <div class="preloader" id="preloader">
        <div id="preloader__animation"></div>
    </div>

    {{-- Burbujas decorativas --}}
    <div class="bubble bubble--1"></div>
    <div class="bubble bubble--2"></div>
    <div class="bubble bubble--3"></div>

    <div class="contact-wrapper">

        {{-- Header --}}
        <div class="contact-header">            
            <h1 class="contact-header__title">Contáctanos</h1>
            <p class="contact-header__subtitle">Déjanos tus datos y te contactaremos a la brevedad</p>
        </div>

        {{-- Formulario --}}
        <form class="contact-form" id="contactForm" method="POST" action="{{ route('leads.store') }}">
            @csrf

            {{-- Hidden fields --}}
            <input type="hidden" name="origin" value="meta">
            <input type="hidden" name="service_interest" value="pagina_web">

            {{-- Nombre --}}
            <div class="form-group">
                <label for="first_name" class="form-label">
                    <i class="fas fa-user"></i> Nombre
                </label>
                <input type="text" id="first_name" name="first_name" class="form-input"
                    placeholder="Tu nombre" maxlength="50" required>
                <span class="form-error" id="error-first_name"></span>
            </div>

            {{-- Apellido --}}
            <div class="form-group">
                <label for="last_name" class="form-label">
                    <i class="fas fa-user"></i> Apellido
                </label>
                <input type="text" id="last_name" name="last_name" class="form-input"
                    placeholder="Tu apellido" maxlength="50" required>
                <span class="form-error" id="error-last_name"></span>
            </div>

            {{-- WhatsApp --}}
            <div class="form-group">
                <label for="whatsapp" class="form-label">
                    <i class="fab fa-whatsapp"></i> WhatsApp
                </label>
                <input type="tel" id="whatsapp" name="whatsapp" class="form-input"
                    placeholder="+57 320 413 25 00" maxlength="20" required>
                <span class="form-error" id="error-whatsapp"></span>
            </div>

            {{-- Correo electrónico --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope"></i> Correo electrónico
                </label>
                <input type="email" id="email" name="email" class="form-input"
                    placeholder="tu@correo.com" maxlength="100">
                <span class="form-error" id="error-email"></span>
            </div>

            {{-- Botón enviar --}}
            <button type="submit" class="form-submit" id="submitBtn">
                <i class="fas fa-paper-plane"></i>
                Enviar solicitud
            </button>

        </form>

    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')

</body>

</html>