{{--
    Formulario de leads para campañas de Meta (página independiente, sin navbar).
    Envío AJAX: js/leads/form.js | Servidor: LeadController@storeMeta

    Parámetros del enlace del anuncio:
    - ?servicio=landing_page → servicio de interés (por defecto pagina_web;
      el servidor solo acepta servicios válidos)
    - ?pais=mx               → país inicial del campo de WhatsApp
    - ?utm_campaign=...      → nombre de la campaña (Meta: {{campaign.name}})
    - ?utm_content=...       → nombre del anuncio  (Meta: {{ad.name}})

    Meta Pixel: el código base va en el <head>; el evento "Lead" se dispara
    en form.js cuando el envío es exitoso.
--}}

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="Agencia especializada en diseño y desarrollo de páginas web, actualizaciones y diseño para ayudar a tu empresa a destacar. Contáctanos para crear una presencia digital única y efectiva." />
    <meta name="author" content="wiquiweb" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>wiquiweb | Contáctanos</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/leads/form.css', 'resources/js/app.js', 'resources/js/leads/form.js'])

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '1769889247506938');
        fbq('track', 'PageView');
    </script>
    <noscript>
        <img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=1769889247506938&ev=PageView&noscript=1" />
    </noscript>
    <!-- End Meta Pixel Code -->
</head>

<body class="page-form">

    <div class="contact-wrapper">

        {{-- Header --}}
        <div class="contact-header">
            <h1 class="contact-header__title">Contáctanos</h1>
            <p class="contact-header__subtitle">Déjanos tus datos y te contactaremos a la brevedad</p>
        </div>

        {{-- Formulario (novalidate: valida el servidor y muestra todos los errores a la vez) --}}
        <form class="contact-form" id="contactForm" method="POST" action="{{ route('leads.meta.store') }}" novalidate>
            @csrf

            {{-- Datos de la campaña: vienen del enlace del anuncio de Meta --}}
            <input type="hidden" name="service_interest" value="{{ request('servicio', 'pagina_web') }}">
            <input type="hidden" name="utm_campaign" value="{{ request('utm_campaign') }}">
            <input type="hidden" name="utm_content" value="{{ request('utm_content') }}">

            {{-- Nombre y Apellido --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name" class="form-label">
                        <i data-lucide="user"></i> Nombre
                    </label>
                    <input type="text" id="first_name" name="first_name" class="form-input" placeholder="Tu nombre"
                        maxlength="50" autocomplete="given-name">
                    <span class="form-error" id="error-first_name"></span>
                </div>
                <div class="form-group">
                    <label for="last_name" class="form-label">
                        <i data-lucide="user"></i> Apellido
                    </label>
                    <input type="text" id="last_name" name="last_name" class="form-input" placeholder="Tu apellido"
                        maxlength="50" autocomplete="family-name">
                    <span class="form-error" id="error-last_name"></span>
                </div>
            </div>

            {{-- WhatsApp (con bandera y selector de país) --}}
            <div class="form-group">
                <label for="whatsapp" class="form-label">
                    <i data-lucide="smartphone"></i> WhatsApp
                </label>
                <x-phone-input name="whatsapp" id="whatsapp" class="form-input" placeholder="320 569 3258" />
                <span class="form-error" id="error-whatsapp"></span>
            </div>

            {{-- Correo electrónico --}}
            <div class="form-group">
                <label for="email" class="form-label">
                    <i data-lucide="mail"></i> Correo electrónico
                </label>
                <input type="email" id="email" name="email" class="form-input" placeholder="tu@correo.com"
                    maxlength="100" autocomplete="email">
                <span class="form-error" id="error-email"></span>
            </div>

            {{-- Política de privacidad --}}
            <div class="form-group form-group--privacy">
                <label class="form-privacy">
                    <input type="checkbox" id="privacy" name="privacy" value="1">
                    <span>
                        He leído y acepto la
                        <a href="{{ route('privacy') }}" target="_blank">Política de Privacidad</a>
                    </span>
                </label>
                <span class="form-error" id="error-privacy"></span>
            </div>

            {{-- Error general (ej: la página estuvo abierta mucho tiempo) --}}
            <span class="form-error" id="error-form"></span>

            {{-- Botón enviar --}}
            <button type="submit" class="form-submit" id="submitBtn">
                <i data-lucide="send"></i>
                Enviar solicitud
            </button>

        </form>

    </div>

</body>

</html>
