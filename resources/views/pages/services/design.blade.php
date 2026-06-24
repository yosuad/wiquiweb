@extends('layouts.app')

@section('title', 'Diseño Gráfico — Wiquiweb')

@push('styles')
    @vite('resources/css/pages/services/design.css')
@endpush

@section('content')

    <!-- ════════════════ HERO ════════════════ -->
    <section class="design-hero">
        <div class="design-hero__container">

            <nav class="design-hero__breadcrumb" aria-label="Breadcrumb">
                <ol class="design-hero__breadcrumb-list">
                    <li class="design-hero__breadcrumb-item">
                        <a href="{{ route('home') }}" class="design-hero__breadcrumb-link">Inicio</a>
                    </li>
                    <li class="design-hero__breadcrumb-item design-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="design-hero__breadcrumb-item">
                        <a href="#" class="design-hero__breadcrumb-link">Servicios</a>
                    </li>
                    <li class="design-hero__breadcrumb-item design-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="design-hero__breadcrumb-item design-hero__breadcrumb-item--active" aria-current="page">
                        Diseño Gráfico
                    </li>
                </ol>
            </nav>

            <div class="design-hero__badge">
                <i data-lucide="palette" aria-hidden="true"></i>
                <span>Diseño Gráfico Profesional</span>
            </div>

            <h1 class="design-hero__title">
                Tu marca merece una <span class="design-hero__title-highlight">identidad visual</span> que impacte
            </h1>

            <p class="design-hero__description">
                Creamos piezas gráficas que comunican, conectan y diferencian tu negocio.
                Desde tu logo hasta tus materiales de comunicación — todo con un diseño que refleja quién eres.
            </p>

            <div class="design-hero__actions">
                <a href="{{ route('contact') }}" class="btn btn--primary">
                    <i data-lucide="send" aria-hidden="true"></i>
                    Solicitar cotización
                </a>
                <a href="#servicios" class="btn btn--outline-light">
                    <i data-lucide="arrow-down" aria-hidden="true"></i>
                    Ver servicios
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════ QUÉ HACEMOS ════════════════ -->
    <section id="servicios" class="design-services">
        <div class="design-services__container">

            <div class="design-services__header">
                <p class="design-services__subtitle">¿Qué hacemos?</p>
                <h2 class="design-services__title">
                    Piezas gráficas que <span class="design-services__title-highlight">hablan por tu negocio</span>
                </h2>
                <p class="design-services__description">
                    Diseñamos todo lo que tu marca necesita para comunicarse de forma profesional y coherente.
                </p>
            </div>

            <div class="design-services__grid">

                <article class="design-card">
                    <div class="design-card__icon"><i data-lucide="star" aria-hidden="true"></i></div>
                    <h3 class="design-card__title">Logotipos</h3>
                    <p class="design-card__text">Tu logo es la cara de tu negocio. Diseñamos identidades visuales únicas, memorables y versátiles que representan exactamente lo que eres.</p>
                </article>

                <article class="design-card">
                    <div class="design-card__icon"><i data-lucide="file-text" aria-hidden="true"></i></div>
                    <h3 class="design-card__title">Plegables y Panfletos</h3>
                    <p class="design-card__text">Material impreso listo para enviar a la imprenta. Diseñamos plegables, volantes y panfletos con una maquetación profesional y atractiva.</p>
                </article>

                <article class="design-card">
                    <div class="design-card__icon"><i data-lucide="package" aria-hidden="true"></i></div>
                    <h3 class="design-card__title">Empaques</h3>
                    <p class="design-card__text">El empaque es el primer contacto físico del cliente con tu producto. Diseñamos empaques que destacan en el punto de venta y refuerzan tu marca.</p>
                </article>

                <article class="design-card">
                    <div class="design-card__icon"><i data-lucide="newspaper" aria-hidden="true"></i></div>
                    <h3 class="design-card__title">Periódicos y Revistas</h3>
                    <p class="design-card__text">Maquetación editorial profesional para medios impresos y digitales. Diseño de portadas, diagramación de contenido y edición lista para publicar.</p>
                </article>

            </div>
        </div>
    </section>

    <!-- ════════════════ HERRAMIENTAS ════════════════ -->
    <section class="design-tools">
        <div class="design-tools__container">

            <div class="design-tools__header">
                <p class="design-tools__subtitle">Cómo trabajamos</p>
                <h2 class="design-tools__title">
                    Herramientas <span class="design-tools__title-highlight">de nivel profesional</span>
                </h2>
                <p class="design-tools__description">
                    Trabajamos con las mismas herramientas que usan las agencias de diseño más grandes del mundo.
                    Archivos editables, vectoriales y listos para cualquier formato o tamaño.
                </p>
            </div>

            <div class="design-tools__grid">

                <div class="design-tool">
                    <div class="design-tool__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h3 class="design-tool__title">Adobe Illustrator</h3>
                    <p class="design-tool__text">Diseño vectorial para logos, íconos e ilustraciones. Archivos escalables a cualquier tamaño sin perder calidad.</p>
                </div>

                <div class="design-tool">
                    <div class="design-tool__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="9" y1="3" x2="9" y2="21"></line>
                        </svg>
                    </div>
                    <h3 class="design-tool__title">Adobe InDesign</h3>
                    <p class="design-tool__text">Maquetación editorial profesional para revistas, periódicos, catálogos y cualquier material impreso de múltiples páginas.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ PROCESO ════════════════ -->
    <section class="design-process">
        <div class="design-process__container">

            <div class="design-process__header">
                <p class="design-process__subtitle">Nuestro proceso</p>
                <h2 class="design-process__title">
                    Del concepto al <span class="design-process__title-highlight">archivo final</span>
                </h2>
                <p class="design-process__description">
                    Un proceso claro y colaborativo para que el resultado sea exactamente lo que necesitas.
                </p>
            </div>

            <div class="design-process__steps">

                <div class="design-step">
                    <div class="design-step__number">01</div>
                    <div class="design-step__icon"><i data-lucide="message-circle" aria-hidden="true"></i></div>
                    <h3 class="design-step__title">Briefing</h3>
                    <p class="design-step__text">Conocemos tu negocio, tu público y lo que quieres transmitir con el diseño.</p>
                </div>

                <div class="design-step__connector" aria-hidden="true"></div>

                <div class="design-step">
                    <div class="design-step__number">02</div>
                    <div class="design-step__icon"><i data-lucide="pen-tool" aria-hidden="true"></i></div>
                    <h3 class="design-step__title">Diseño y revisión</h3>
                    <p class="design-step__text">Creamos propuestas visuales y aplicamos los ajustes que necesites hasta quedar satisfecho.</p>
                </div>

                <div class="design-step__connector" aria-hidden="true"></div>

                <div class="design-step">
                    <div class="design-step__number">03</div>
                    <div class="design-step__icon"><i data-lucide="download" aria-hidden="true"></i></div>
                    <h3 class="design-step__title">Entrega de archivos</h3>
                    <p class="design-step__text">Recibes todos los archivos en los formatos que necesitas — listos para imprimir o usar digitalmente.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════════ CTA ════════════════ -->
    <section class="design-cta">
        <div class="design-cta__container">
            <p class="design-cta__subtitle">¿Listo para destacar?</p>
            <h2 class="design-cta__title">Dale a tu marca la imagen que merece</h2>
            <p class="design-cta__description">
                Contáctanos y en menos de 24 horas te damos una cotización personalizada.
            </p>
            <a href="{{ route('contact') }}" class="btn btn--primary">
                <i data-lucide="send" aria-hidden="true"></i>
                Solicitar cotización
            </a>
        </div>
    </section>

@endsection