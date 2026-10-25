@extends('layouts.app')

@section('title', 'Diseño de Páginas Web — WiquiWeb')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/service-web-design.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/service-web-design.js') }}" defer></script>
@endpush

@section('content')

    <!-- ════════════════ PAGE HERO ════════════════ -->
    <section class="page-hero">

        <div class="page-hero__container">

            <nav class="page-hero__breadcrumb" aria-label="Breadcrumb">
                <ol class="page-hero__breadcrumb-list">
                    <li class="page-hero__breadcrumb-item">
                        <a href="{{ route('home') }}" class="page-hero__breadcrumb-link">Inicio</a>
                    </li>
                    <li class="page-hero__breadcrumb-item page-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="page-hero__breadcrumb-item">
                        <a href="#" class="page-hero__breadcrumb-link">Servicios</a>
                    </li>
                    <li class="page-hero__breadcrumb-item page-hero__breadcrumb-item--sep" aria-hidden="true">/</li>
                    <li class="page-hero__breadcrumb-item page-hero__breadcrumb-item--active" aria-current="page">
                        Diseño Web
                    </li>
                </ol>
            </nav>

            <div class="page-hero__badge">
                <i data-lucide="globe" aria-hidden="true"></i>
                <span>Diseño Web Profesional</span>
            </div>

            <h1 class="page-hero__title">
                Páginas Web que <span class="page-hero__title-highlight">convierten</span> visitas en clientes
            </h1>

            <p class="page-hero__description">
                Diseñamos y desarrollamos sitios web modernos, rápidos y optimizados para buscadores.
                Tu presencia digital, llevada al siguiente nivel.
            </p>

            <div class="page-hero__actions">
                <a href="#precios" class="btn btn--primary">
                    <i data-lucide="tag" aria-hidden="true"></i>
                    Ver planes y precios
                </a>
                <a href="#contacto" class="btn btn--outline-light">
                    <i data-lucide="message-circle" aria-hidden="true"></i>
                    Hablar con un asesor
                </a>
            </div>

            <div class="page-hero__stats" aria-label="Estadísticas rápidas">
                <div class="page-hero__stat">
                    <span class="page-hero__stat-number">+45</span>
                    <span class="page-hero__stat-label">Sitios creados</span>
                </div>
                <div class="page-hero__stat-divider" aria-hidden="true"></div>
                <div class="page-hero__stat">
                    <span class="page-hero__stat-number">100%</span>
                    <span class="page-hero__stat-label">Responsivos</span>
                </div>
                <div class="page-hero__stat-divider" aria-hidden="true"></div>
                <div class="page-hero__stat">
                    <span class="page-hero__stat-number">48h</span>
                    <span class="page-hero__stat-label">Primer prototipo</span>
                </div>
            </div>

        </div>

        <div class="page-hero__visual" aria-hidden="true">
            <div class="browser-mockup">
                <div class="browser-mockup__bar">
                    <span class="browser-mockup__dot browser-mockup__dot--red"></span>
                    <span class="browser-mockup__dot browser-mockup__dot--yellow"></span>
                    <span class="browser-mockup__dot browser-mockup__dot--green"></span>
                    <div class="browser-mockup__url">wiquiweb.com</div>
                </div>
                <div class="browser-mockup__screen">
                    <img src="{{ asset('images/web-mockup.jpg') }}"
                         alt="Vista previa de diseño web"
                         class="browser-mockup__image"
                         loading="lazy">
                </div>
            </div>
        </div>

    </section>

    <!-- ════════════ SERVICE FEATURES — ¿QUÉ INCLUYE? ════════════ -->
    <section class="service-features">
        <div class="service-features__container">

            <div class="service-features__header">
                <p class="service-features__subtitle">¿Qué incluye?</p>
                <h2 class="service-features__title">
                    Todo lo que tu web <span class="service-features__title-highlight">necesita</span>
                </h2>
                <p class="service-features__description">
                    Cada proyecto viene con un paquete completo para que no tengas que preocuparte por nada técnico.
                </p>
            </div>

            <div class="service-features__grid">

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="smartphone" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">Diseño Responsivo</h3>
                        <p class="feature-item__text">Tu sitio se adapta perfectamente a todos los dispositivos: móvil, tablet y escritorio.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="search" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">SEO Optimizado</h3>
                        <p class="feature-item__text">Estructura técnica para que Google encuentre y posicione tu sitio desde el primer día.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="zap" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">Carga Ultra Rápida</h3>
                        <p class="feature-item__text">Imágenes optimizadas, caché y código limpio para tiempos de carga menores a 2 segundos.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="shield-check" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">Certificado SSL</h3>
                        <p class="feature-item__text">Conexión segura HTTPS incluida. Protege a tus visitantes y mejora tu ranking en Google.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="palette" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">Diseño Personalizado</h3>
                        <p class="feature-item__text">Cada sitio es único. Creamos una identidad visual que refleja exactamente tu marca.</p>
                    </div>
                </div>

                <div class="feature-item">
                    <div class="feature-item__icon"><i data-lucide="headphones" aria-hidden="true"></i></div>
                    <div class="feature-item__body">
                        <h3 class="feature-item__title">Soporte Post-Lanzamiento</h3>
                        <p class="feature-item__text">Acompañamiento tras el lanzamiento para resolver dudas y realizar ajustes menores.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════ WEB TYPES ════════════ -->
    <section class="web-types">
        <div class="web-types__container">

            <div class="web-types__header">
                <p class="web-types__subtitle">¿Qué tipo necesitas?</p>
                <h2 class="web-types__title">
                    Tipos de <span class="web-types__title-highlight">sitios web</span>
                </h2>
                <p class="web-types__description">
                    Diseñamos cualquier tipo de sitio, adaptado a tu industria y objetivos de negocio.
                </p>
            </div>

            <div class="web-types__grid">

                <article class="web-type-card">
                    <div class="web-type-card__icon"><i data-lucide="layout-template" aria-hidden="true"></i></div>
                    <h3 class="web-type-card__title">Landing Page</h3>
                    <p class="web-type-card__text">Página enfocada en convertir visitas en clientes. Ideal para campañas y promociones.</p>
                    <ul class="web-type-card__list" aria-label="Incluye">
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            1 página optimizada para conversión
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Formulario de contacto
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Integración WhatsApp
                        </li>
                    </ul>
                </article>

                <article class="web-type-card web-type-card--featured">
                    <div class="web-type-card__badge">Popular</div>
                    <div class="web-type-card__icon"><i data-lucide="building-2" aria-hidden="true"></i></div>
                    <h3 class="web-type-card__title">Sitio Corporativo</h3>
                    <p class="web-type-card__text">Presencia digital completa para tu empresa. Transmite profesionalismo y genera confianza.</p>
                    <ul class="web-type-card__list" aria-label="Incluye">
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Hasta 8 secciones personalizadas
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Blog integrado
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Panel de administración
                        </li>
                    </ul>
                </article>

                <article class="web-type-card">
                    <div class="web-type-card__icon"><i data-lucide="shopping-cart" aria-hidden="true"></i></div>
                    <h3 class="web-type-card__title">Tienda Online</h3>
                    <p class="web-type-card__text">Vende tus productos las 24 horas. E-commerce completo con pasarela de pago integrada.</p>
                    <ul class="web-type-card__list" aria-label="Incluye">
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Catálogo de productos
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Carrito de compras
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Pasarela de pagos
                        </li>
                    </ul>
                </article>

                <article class="web-type-card">
                    <div class="web-type-card__icon"><i data-lucide="newspaper" aria-hidden="true"></i></div>
                    <h3 class="web-type-card__title">Blog / Noticias</h3>
                    <p class="web-type-card__text">Publica contenido relevante para tu audiencia y posiciónate como referente del sector.</p>
                    <ul class="web-type-card__list" aria-label="Incluye">
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Sistema de artículos
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Categorías y etiquetas
                        </li>
                        <li class="web-type-card__list-item">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Suscripción por email
                        </li>
                    </ul>
                </article>

            </div>
        </div>
    </section>

    <!-- ════════════ PRICING ════════════ -->
    <section id="precios" class="pricing">
        <div class="pricing__container">

            <div class="pricing__header">
                <p class="pricing__subtitle">Inversión</p>
                <h2 class="pricing__title">
                    Planes y <span class="pricing__title-highlight">Precios</span>
                </h2>
                <p class="pricing__description">
                    Elige el plan que mejor se adapte a tu negocio. Sin costos ocultos, sin sorpresas.
                </p>
            </div>

            <div class="pricing__grid">

                <!-- Plan Básico -->
                <div class="pricing-card">
                    <div class="pricing-card__header">
                        <span class="pricing-card__plan">Básico</span>
                        <div class="pricing-card__price">
                            <span class="pricing-card__currency">$</span>
                            <span class="pricing-card__amount">299</span>
                            <span class="pricing-card__period">USD</span>
                        </div>
                        <p class="pricing-card__tagline">Ideal para emprendedores</p>
                    </div>
                    <ul class="pricing-card__list" aria-label="Características del plan básico">
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Landing page (1 página)
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Diseño responsivo
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Formulario de contacto
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Integración redes sociales
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Certificado SSL
                        </li>
                        <li class="pricing-card__item pricing-card__item--excluded" aria-label="No incluido">
                            <i data-lucide="x" aria-hidden="true"></i>
                            Blog integrado
                        </li>
                        <li class="pricing-card__item pricing-card__item--excluded" aria-label="No incluido">
                            <i data-lucide="x" aria-hidden="true"></i>
                            Panel de administración
                        </li>
                        <li class="pricing-card__item pricing-card__item--excluded" aria-label="No incluido">
                            <i data-lucide="x" aria-hidden="true"></i>
                            SEO avanzado
                        </li>
                    </ul>
                    <a href="#contacto" class="pricing-card__btn pricing-card__btn--outline">Solicitar plan</a>
                </div>

                <!-- Plan Profesional (destacado) -->
                <div class="pricing-card pricing-card--featured">
                    <div class="pricing-card__badge">Más popular</div>
                    <div class="pricing-card__header">
                        <span class="pricing-card__plan">Profesional</span>
                        <div class="pricing-card__price">
                            <span class="pricing-card__currency">$</span>
                            <span class="pricing-card__amount">699</span>
                            <span class="pricing-card__period">USD</span>
                        </div>
                        <p class="pricing-card__tagline">Para negocios en crecimiento</p>
                    </div>
                    <ul class="pricing-card__list" aria-label="Características del plan profesional">
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Sitio corporativo (hasta 8 secciones)
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Diseño responsivo
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Panel de administración
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Blog integrado
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            SEO optimizado
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Certificado SSL
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Integración Google Analytics
                        </li>
                        <li class="pricing-card__item pricing-card__item--excluded" aria-label="No incluido">
                            <i data-lucide="x" aria-hidden="true"></i>
                            Tienda online / e-commerce
                        </li>
                    </ul>
                    <a href="#contacto" class="pricing-card__btn pricing-card__btn--primary">Solicitar plan</a>
                </div>

                <!-- Plan Premium -->
                <div class="pricing-card">
                    <div class="pricing-card__header">
                        <span class="pricing-card__plan">Premium</span>
                        <div class="pricing-card__price">
                            <span class="pricing-card__currency">$</span>
                            <span class="pricing-card__amount">1.299</span>
                            <span class="pricing-card__period">USD</span>
                        </div>
                        <p class="pricing-card__tagline">Solución completa para empresas</p>
                    </div>
                    <ul class="pricing-card__list" aria-label="Características del plan premium">
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Sitio corporativo completo
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Tienda online integrada
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Panel de administración
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            SEO avanzado
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Pasarela de pagos
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Certificado SSL
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Google Analytics + Search Console
                        </li>
                        <li class="pricing-card__item pricing-card__item--included">
                            <i data-lucide="check" aria-hidden="true"></i>
                            Soporte 3 meses incluido
                        </li>
                    </ul>
                    <a href="#contacto" class="pricing-card__btn pricing-card__btn--outline">Solicitar plan</a>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════ WEB PROCESS ════════════ -->
    <section class="web-process">
        <div class="web-process__container">

            <div class="web-process__header">
                <p class="web-process__subtitle">Cómo Trabajamos</p>
                <h2 class="web-process__title">
                    De la idea al <span class="web-process__title-highlight">lanzamiento</span>
                </h2>
                <p class="web-process__description">
                    Un proceso ágil y transparente para convertir tu visión en realidad digital.
                </p>
            </div>

            <div class="web-process__track">
                <div class="web-process__line" aria-hidden="true"></div>

                <div class="process-step">
                    <div class="process-step__bubble">
                        <div class="process-step__icon">
                            <i data-lucide="message-circle" aria-hidden="true"></i>
                        </div>
                        <span class="process-step__number" aria-hidden="true">01</span>
                    </div>
                    <h3 class="process-step__title">Briefing</h3>
                    <p class="process-step__text">Conocemos tu negocio, objetivos y público objetivo en una reunión inicial.</p>
                </div>

                <div class="process-step">
                    <div class="process-step__bubble">
                        <div class="process-step__icon">
                            <i data-lucide="pen-tool" aria-hidden="true"></i>
                        </div>
                        <span class="process-step__number" aria-hidden="true">02</span>
                    </div>
                    <h3 class="process-step__title">Prototipo</h3>
                    <p class="process-step__text">Diseñamos wireframes y mockups para validar la estructura visual contigo.</p>
                </div>

                <div class="process-step">
                    <div class="process-step__bubble">
                        <div class="process-step__icon">
                            <i data-lucide="code-2" aria-hidden="true"></i>
                        </div>
                        <span class="process-step__number" aria-hidden="true">03</span>
                    </div>
                    <h3 class="process-step__title">Desarrollo</h3>
                    <p class="process-step__text">Programación limpia y optimizada con las mejores tecnologías del mercado.</p>
                </div>

                <div class="process-step">
                    <div class="process-step__bubble">
                        <div class="process-step__icon">
                            <i data-lucide="eye" aria-hidden="true"></i>
                        </div>
                        <span class="process-step__number" aria-hidden="true">04</span>
                    </div>
                    <h3 class="process-step__title">Revisión</h3>
                    <p class="process-step__text">Te mostramos el resultado final y aplicamos los ajustes que necesites.</p>
                </div>

                <div class="process-step">
                    <div class="process-step__bubble">
                        <div class="process-step__icon">
                            <i data-lucide="rocket" aria-hidden="true"></i>
                        </div>
                        <span class="process-step__number" aria-hidden="true">05</span>
                    </div>
                    <h3 class="process-step__title">Lanzamiento</h3>
                    <p class="process-step__text">Publicamos tu sitio y te entregamos accesos, capacitación y soporte.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════ FAQ ════════════ -->
    <section class="faq">
        <div class="faq__container">

            <div class="faq__header">
                <p class="faq__subtitle">Preguntas Frecuentes</p>
                <h2 class="faq__title">
                    ¿Tienes <span class="faq__title-highlight">dudas?</span>
                </h2>
                <p class="faq__description">Estas son las preguntas que más nos hacen antes de contratar.</p>
            </div>

            <div class="faq__list" role="list">

                <div class="faq-item" role="listitem">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Cuánto tiempo tarda en estar listo mi sitio web?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">
                            Depende del plan elegido. Las landing pages suelen estar listas en 5–7 días hábiles.
                            Los sitios corporativos toman de 2 a 3 semanas y los e-commerce de 3 a 4 semanas.
                        </p>
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Qué necesito tener listo antes de empezar?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">
                            Idealmente tu logo, colores de marca, textos e imágenes de tu empresa.
                            Si no tienes alguno de estos elementos, podemos ayudarte a crearlos o conseguirlos.
                        </p>
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Puedo actualizar el contenido yo mismo después?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">
                            Sí. Los planes Profesional y Premium incluyen un panel de administración intuitivo
                            para editar textos, imágenes y contenido sin necesitar conocimientos técnicos.
                        </p>
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿El precio incluye el hosting y el dominio?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">
                            El diseño y desarrollo está incluido en el precio del plan. El hosting y dominio
                            se cobran por separado de forma anual. Podemos gestionar todo por ti a un costo muy accesible.
                        </p>
                    </div>
                </div>

                <div class="faq-item" role="listitem">
                    <button class="faq-item__trigger" aria-expanded="false" data-faq-trigger>
                        <span class="faq-item__question">¿Ofrecen mantenimiento después del lanzamiento?</span>
                        <i class="faq-item__icon" data-lucide="chevron-down" aria-hidden="true"></i>
                    </button>
                    <div class="faq-item__body" aria-hidden="true">
                        <p class="faq-item__answer">
                            Sí, contamos con planes de mantenimiento mensual que incluyen actualizaciones,
                            backups automáticos, monitoreo de seguridad y modificaciones de contenido.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ════════════ SERVICE CTA ════════════ -->
    <section id="contacto" class="service-cta">
        <div class="service-cta__container">
            <div class="service-cta__content">

                <p class="service-cta__subtitle">¿Listo para empezar?</p>
                <h2 class="service-cta__title">Tu web profesional te espera</h2>
                <p class="service-cta__description">
                    Contáctanos hoy y recibe una cotización personalizada sin compromiso en menos de 24 horas.
                </p>

                <div class="service-cta__actions">
                    <a href="https://wa.me/573000000000"
                       target="_blank"
                       rel="noopener noreferrer"
                       class="btn btn--primary">
                        <i data-lucide="message-circle" aria-hidden="true"></i>
                        Escríbenos por WhatsApp
                    </a>
                    <a href="mailto:info@wiquiweb.com" class="btn btn--ghost">
                        <i data-lucide="mail" aria-hidden="true"></i>
                        Enviar correo
                    </a>
                </div>

            </div>
        </div>
    </section>

@endsection
