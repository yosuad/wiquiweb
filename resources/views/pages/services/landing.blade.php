@extends('layouts.app')

@section('title', 'Landing Pages — Wiquiweb')

@push('styles')
    @vite('resources/css/pages/services/landing.css')
@endpush

@section('content')

    <!-- ════════════════ HERO ════════════════ -->
    <section class="landing-hero">
        <div class="landing-hero__container">

            <nav class="landing-hero__breadcrumb" aria-label="Breadcrumb">
                <ol class="landing-hero__breadcrumb-list">
                    <li class="landing-hero__breadcrumb-item">
                        <a href="{{ route('home') }}" class="landing-hero__breadcrumb-link">Inicio</a>
                    </li>
                    <li class="landing-hero__breadcrumb-item landing-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="landing-hero__breadcrumb-item">
                        <a href="#" class="landing-hero__breadcrumb-link">Servicios</a>
                    </li>
                    <li class="landing-hero__breadcrumb-item landing-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="landing-hero__breadcrumb-item landing-hero__breadcrumb-item--active" aria-current="page">
                        Landing Pages
                    </li>
                </ol>
            </nav>

            <div class="landing-hero__badge">
                <i data-lucide="layout" aria-hidden="true"></i>
                <span>Landing Pages</span>
            </div>

            <h1 class="landing-hero__title">
                Tu presencia digital, tu mejor <span class="landing-hero__title-highlight">carta de presentación</span>
            </h1>

            <p class="landing-hero__description">
                Tener una página web no es un lujo — es crecer. Es estar disponible las 24 horas,
                llegar a más personas y proyectar la imagen que tu negocio, organización o proyecto artístico merece.
                Desde Wiquiweb te acompañamos en ese proceso.
            </p>

            <div class="landing-hero__actions">
                <a href="{{ route('contact') }}" class="btn btn--primary">
                    <i data-lucide="send" aria-hidden="true"></i>
                    Quiero mi landing page
                </a>
                <a href="#como-funciona" class="btn btn--outline-light">
                    <i data-lucide="arrow-down" aria-hidden="true"></i>
                    ¿Cómo funciona?
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════ CÓMO FUNCIONA ════════════════ -->
    <section id="como-funciona" class="landing-how">
        <div class="landing-how__container">

            <div class="landing-how__header">
                <p class="landing-how__subtitle">¿Cómo funciona?</p>
                <h2 class="landing-how__title">
                    Un proceso claro, <span class="landing-how__title-highlight">sin sorpresas</span>
                </h2>
                <p class="landing-how__description">
                    Para que tu página quede exactamente como la imaginas, trabajamos juntos desde el primer día.
                </p>
            </div>

            <div class="landing-how__cols">

                <!-- Lo que hace Wiquiweb -->
                <div class="landing-col">
                    <div class="landing-col__header landing-col__header--primary">
                        <i data-lucide="laptop" aria-hidden="true"></i>
                        <h3 class="landing-col__title">Lo que hacemos nosotros</h3>
                    </div>
                    <ul class="landing-col__list">
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Diseño y desarrollo de tu landing page
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Adaptada a tu identidad visual y tu audiencia
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Optimizada para móvil y buscadores
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Integración de redes sociales y formulario de contacto
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Publicación y configuración del dominio
                        </li>
                    </ul>
                </div>

                <!-- Lo que entrega el cliente -->
                <div class="landing-col">
                    <div class="landing-col__header landing-col__header--secondary">
                        <i data-lucide="user" aria-hidden="true"></i>
                        <h3 class="landing-col__title">Lo que tú nos entregas</h3>
                    </div>
                    <ul class="landing-col__list">
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Brief de marca</strong> — colores, estilo visual y referencias
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Logo</strong> en alta resolución (PDF o AI)
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Biografía</strong> — quién eres y qué haces
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Fotos profesionales</strong> — mínimo 3 en buena resolución
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Servicios, discografía o trayectoria</strong>
                        </li>
                        <li class="landing-col__item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            <strong>Links de redes sociales</strong>
                        </li>
                    </ul>
                    <div class="landing-col__note">
                        <i data-lucide="info" aria-hidden="true"></i>
                        <p>El diseño de logo, redacción de textos y fotografía profesional son servicios adicionales que
                            puedes contratar por separado.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ CASOS DE ÉXITO ════════════════ -->
    <section class="landing-cases">
        <div class="landing-cases__container">

            <div class="landing-cases__header">
                <p class="landing-cases__subtitle">Casos de éxito</p>
                <h2 class="landing-cases__title">
                    Clientes que <span class="landing-cases__title-highlight">confiaron en nosotros</span>
                </h2>
                <p class="landing-cases__description">
                    Cada proyecto es diferente. Aquí te mostramos cómo hemos ayudado a artistas, negocios y organizaciones a
                    tener una presencia digital profesional.
                </p>
            </div>

            <div class="landing-cases__grid">

                {{-- Yosuad --}}
                <article class="landing-case">
                    <div class="landing-case__image-wrapper">
                        <img src="{{ asset('img/portfolio/yosuad.webp') }}" alt="Yosuad" class="landing-case__image"
                            loading="lazy">
                        <span class="landing-case__tag">Artista</span>
                    </div>
                    <div class="landing-case__body">
                        <h3 class="landing-case__title">Yosuad</h3>
                        <p class="landing-case__text">Rapero de la ciudad con una trayectoria sólida. Desarrollamos su
                            landing page artística con diseño personalizado que refleja su identidad musical y conecta con
                            su audiencia.</p>
                        <div class="landing-case__services">
                            <span class="landing-case__service">Diseño web</span>
                            <span class="landing-case__service">Landing page</span>
                        </div>
                        <a href="{{ route('portfolio.yosuad') }}" class="landing-case__link">
                            Ver demo <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Canal Zona 6 --}}
                <article class="landing-case">
                    <div class="landing-case__image-wrapper">
                        <img src="{{ asset('img/portfolio/canalzona6tv.webp') }}" alt="Canal Zona 6 TV"
                            class="landing-case__image" loading="lazy">
                        <span class="landing-case__tag">Organización</span>
                    </div>
                    <div class="landing-case__body">
                        <h3 class="landing-case__title">Canal Zona 6 TV</h3>
                        <p class="landing-case__text">Canal de televisión comunitario que necesitaba una presencia digital
                            a la altura de su audiencia. Diseñamos su identidad gráfica y desarrollamos su landing page
                            institucional.</p>
                        <div class="landing-case__services">
                            <span class="landing-case__service">Diseño gráfico</span>
                            <span class="landing-case__service">Landing page</span>
                        </div>
                        <a href="https://wiquiweb.co/canalzona6tv" target="_blank" rel="noopener noreferrer"
                            class="landing-case__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Persianas y Cortinas Valencia --}}
                <article class="landing-case">
                    <div class="landing-case__image-wrapper">
                        <img src="{{ asset('img/portfolio/persianasycortinasvalencia.webp') }}"
                            alt="Persianas y Cortinas Valencia" class="landing-case__image" loading="lazy">
                        <span class="landing-case__tag">Negocio</span>
                    </div>
                    <div class="landing-case__body">
                        <h3 class="landing-case__title">Persianas y Cortinas Valencia</h3>
                        <p class="landing-case__text">Negocio local que quería proyectar una imagen más profesional en
                            línea. Diseñamos su identidad gráfica y una landing page optimizada para convertir visitas en
                            clientes.</p>
                        <div class="landing-case__services">
                            <span class="landing-case__service">Diseño gráfico</span>
                            <span class="landing-case__service">Landing page</span>
                        </div>
                        <a href="https://wiquiweb.co/persianasycortinasvalencia" target="_blank"
                            rel="noopener noreferrer" class="landing-case__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ════════════════ CTA ════════════════ -->
    <section class="landing-cta">
        <div class="landing-cta__container">
            <p class="landing-cta__subtitle">¿Listo para dar el siguiente paso?</p>
            <h2 class="landing-cta__title">Tu página web te está esperando</h2>
            <p class="landing-cta__description">
                Contáctanos y en menos de 24 horas te damos una cotización personalizada.
            </p>
            <a href="{{ route('contact') }}" class="btn btn--primary">
                <i data-lucide="send" aria-hidden="true"></i>
                Quiero mi landing page
            </a>
        </div>
    </section>

@endsection
