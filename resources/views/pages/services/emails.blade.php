@extends('layouts.app')

@section('title', 'Correos Corporativos — Wiquiweb')

@push('styles')
    @vite('resources/css/pages/services/emails.css')
@endpush

@section('content')

    <!-- ════════════════ HERO ════════════════ -->
    <section class="email-hero">
        <div class="email-hero__container">

            <nav class="email-hero__breadcrumb" aria-label="Breadcrumb">
                <ol class="email-hero__breadcrumb-list">
                    <li class="email-hero__breadcrumb-item">
                        <a href="{{ route('home') }}" class="email-hero__breadcrumb-link">Inicio</a>
                    </li>
                    <li class="email-hero__breadcrumb-item email-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="email-hero__breadcrumb-item">
                        <a href="#" class="email-hero__breadcrumb-link">Servicios</a>
                    </li>
                    <li class="email-hero__breadcrumb-item email-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="email-hero__breadcrumb-item email-hero__breadcrumb-item--active" aria-current="page">
                        Correos Corporativos
                    </li>
                </ol>
            </nav>

            <div class="email-hero__badge">
                <i data-lucide="mail" aria-hidden="true"></i>
                <span>Correos Corporativos</span>
            </div>

            <h1 class="email-hero__title">
                Proyecta profesionalismo desde <span class="email-hero__title-highlight">el primer mensaje</span>
            </h1>

            <p class="email-hero__description">
                Tu correo es la primera impresión que das. Un correo con tu propio dominio genera confianza,
                credibilidad y diferencia tu negocio de la competencia.
            </p>

            <div class="email-hero__actions">
                <a href="{{ route('contact') }}" class="btn btn--primary">
                    <i data-lucide="send" aria-hidden="true"></i>
                    Solicitar cotización
                </a>
                <a href="#como-lo-hacemos" class="btn btn--outline-light">
                    <i data-lucide="arrow-down" aria-hidden="true"></i>
                    Cómo lo hacemos
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════ QUÉ INCLUYE ════════════════ -->
    <section class="email-features">
        <div class="email-features__container">

            <div class="email-features__header">
                <p class="email-features__subtitle">¿Qué obtienes?</p>
                <h2 class="email-features__title">
                    Todo lo que necesitas para <span class="email-features__title-highlight">comunicarte profesionalmente</span>
                </h2>
                <p class="email-features__description">
                    Configuramos tu correo corporativo de principio a fin para que solo te preocupes por escribir.
                </p>
            </div>

            <div class="email-features__grid">

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="at-sign" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Correo con tu dominio</h3>
                        <p class="email-feature__text">Tu dirección de correo lleva el nombre de tu empresa. Ej: info@tunegocio.com</p>
                    </div>
                </div>

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="smartphone" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Acceso desde cualquier dispositivo</h3>
                        <p class="email-feature__text">Configura tu correo en computador, celular o tablet. Siempre conectado.</p>
                    </div>
                </div>

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="settings" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Configuración completa incluida</h3>
                        <p class="email-feature__text">Te dejamos todo funcionando. No necesitas conocimientos técnicos.</p>
                    </div>
                </div>

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="shield-check" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Seguro y confiable</h3>
                        <p class="email-feature__text">Protección antispam y antivirus incluida para mantener tu bandeja limpia.</p>
                    </div>
                </div>

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="users" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Para equipos de cualquier tamaño</h3>
                        <p class="email-feature__text">Desde un solo correo hasta soluciones para equipos grandes. Escalable según tu negocio.</p>
                    </div>
                </div>

                <div class="email-feature">
                    <div class="email-feature__icon"><i data-lucide="headphones" aria-hidden="true"></i></div>
                    <div class="email-feature__body">
                        <h3 class="email-feature__title">Soporte incluido</h3>
                        <p class="email-feature__text">Si tienes algún problema, te ayudamos a resolverlo rápidamente.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ CÓMO LO HACEMOS ════════════════ -->
    <section id="como-lo-hacemos" class="email-process">
        <div class="email-process__container">

            <div class="email-process__header">
                <p class="email-process__subtitle">Nuestro proceso</p>
                <h2 class="email-process__title">
                    Simple, rápido y <span class="email-process__title-highlight">sin complicaciones</span>
                </h2>
                <p class="email-process__description">
                    En tres pasos tendrás tu correo corporativo funcionando.
                </p>
            </div>

            <div class="email-process__steps">

                <div class="email-step">
                    <div class="email-step__number">01</div>
                    <div class="email-step__icon"><i data-lucide="search" aria-hidden="true"></i></div>
                    <h3 class="email-step__title">Evaluamos tus necesidades</h3>
                    <p class="email-step__text">Analizamos el tamaño de tu equipo y el uso que le darás para recomendarte la mejor solución.</p>
                </div>

                <div class="email-step__connector" aria-hidden="true"></div>

                <div class="email-step">
                    <div class="email-step__number">02</div>
                    <div class="email-step__icon"><i data-lucide="settings-2" aria-hidden="true"></i></div>
                    <h3 class="email-step__title">Configuramos todo</h3>
                    <p class="email-step__text">Creamos y configuramos tus cuentas de correo con la solución ideal para tu negocio.</p>
                </div>

                <div class="email-step__connector" aria-hidden="true"></div>

                <div class="email-step">
                    <div class="email-step__number">03</div>
                    <div class="email-step__icon"><i data-lucide="check-circle" aria-hidden="true"></i></div>
                    <h3 class="email-step__title">Te dejamos funcionando</h3>
                    <p class="email-step__text">Instalamos tu correo en todos tus dispositivos y te explicamos cómo usarlo. Listo para comunicarte.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ FAQ ════════════════ -->
    <section class="email-faq">
        <div class="email-faq__container">

            <div class="email-faq__header">
                <p class="email-faq__subtitle">Preguntas frecuentes</p>
                <h2 class="email-faq__title">
                    ¿Tienes <span class="email-faq__title-highlight">dudas?</span>
                </h2>
            </div>

            <div class="email-faq__list">

                <div class="faq-item">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Necesito tener un dominio para tener correo corporativo?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">Sí, necesitas un dominio (ej: tunegocio.com). Si aún no tienes uno, podemos ayudarte a conseguirlo a un costo muy accesible.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Cuántos correos puedo tener?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">Depende de las necesidades de tu negocio. Desde un solo correo hasta soluciones para equipos completos. Contáctanos y te recomendamos la opción ideal según tu caso.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿En qué aplicación puedo usar mi correo?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">Lo configuramos en Outlook, Gmail, o cualquier gestor de correo que prefieras. También puedes acceder desde el navegador sin instalar nada.</p>
                    </div>
                </div>

                <div class="faq-item">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Cuánto tiempo tarda la configuración?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">En la mayoría de casos en menos de 24 horas tienes tu correo funcionando. Todo depende de la disponibilidad de tu dominio y la complejidad del servicio.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ CTA ════════════════ -->
    <section class="email-cta">
        <div class="email-cta__container">
            <p class="email-cta__subtitle">¿Listo para proyectar profesionalismo?</p>
            <h2 class="email-cta__title">Empieza hoy con tu correo corporativo</h2>
            <p class="email-cta__description">
                Contáctanos y en menos de 24 horas te damos una cotización personalizada.
            </p>
            <a href="{{ route('contact') }}" class="btn btn--primary">
                <i data-lucide="send" aria-hidden="true"></i>
                Solicitar cotización
            </a>
        </div>
    </section>

@endsection

@push('scripts')
