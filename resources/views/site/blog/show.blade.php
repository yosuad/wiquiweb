@extends('layouts.app')

@section('title', 'EFFIX 2026: Cómo diseñamos la plataforma digital del evento')

@section('content')

    <!-- ════════════════ HERO DEL ARTÍCULO ═══════════════ -->
    <section class="blog-show-hero">
        <div class="blog-show-hero__container">

            <div class="blog-show-hero__meta">
                <a href="{{ route('blog') }}" class="blog-show-hero__back">
                    <i data-lucide="arrow-left"></i>
                    Volver al blog
                </a>
                <span class="blog-show-hero__category">Diseño Web</span>
            </div>

            <h1 class="blog-show-hero__title">
                EFFIX 2026: Cómo diseñamos la plataforma digital del evento
            </h1>

            <div class="blog-show-hero__info">
                <div class="blog-show-hero__author">
                    <div class="blog-show-hero__author-avatar">
                        <i data-lucide="user"></i>
                    </div>
                    <div>
                        <span class="blog-show-hero__author-name">Equipo Wiquiweb</span>
                        <span class="blog-show-hero__author-role">Diseño & Desarrollo</span>
                    </div>
                </div>
                <div class="blog-show-hero__details">
                    <span class="blog-show-hero__detail">
                        <i data-lucide="calendar"></i>
                        15 de octubre, 2026
                    </span>
                    <span class="blog-show-hero__detail">
                        <i data-lucide="clock"></i>
                        5 min de lectura
                    </span>
                </div>
            </div>

        </div>
    </section>

    <!-- ════════════════ IMAGEN PRINCIPAL ═══════════════ -->
    <div class="blog-show-cover">
        <div class="blog-show-cover__container">
            <img src="{{ asset('img/blog/effix-2026.webp') }}" alt="EFFIX 2026" class="blog-show-cover__image">
        </div>
    </div>

    <!-- ════════════════ CONTENIDO ═══════════════ -->
    <section class="blog-show-content">
        <div class="blog-show-content__container">

            <!-- Artículo -->
            <article class="blog-show-article">

                <p class="blog-show-article__lead">
                    EFFIX 2026 fue uno de los proyectos más retadores que hemos enfrentado en Wiquiweb. Un festival
                    empresarial con cientos de asistentes, múltiples expositores y la necesidad de una plataforma digital
                    que estuviera a la altura del evento.
                </p>

                <h2>El reto</h2>
                <p>
                    El cliente llegó con una idea clara pero sin ningún activo digital: sin dominio, sin marca visual y
                    con un plazo de tres semanas para tener todo funcionando. El sitio debía servir como punto de
                    información para asistentes, herramienta de registro y escaparate para los patrocinadores.
                </p>

                <h2>Arquitectura de información</h2>
                <p>
                    Lo primero fue definir qué páginas necesitaba el sitio y cómo se conectaban entre sí. Establecimos
                    una estructura de cinco secciones principales:
                </p>
                <ul>
                    <li><strong>Inicio</strong> — Hero con cuenta regresiva y llamado a la acción de registro</li>
                    <li><strong>Ponentes</strong> — Grid de expositores con perfil y tema de charla</li>
                    <li><strong>Agenda</strong> — Cronograma del evento por día y sala</li>
                    <li><strong>Patrocinadores</strong> — Logos organizados por nivel de patrocinio</li>
                    <li><strong>Registro</strong> — Formulario de inscripción con integración a Mailchimp</li>
                </ul>

                <h2>Identidad visual</h2>
                <p>
                    Para EFFIX definimos una paleta basada en azul profundo y dorado, buscando transmitir autoridad y
                    exclusividad. La tipografía elegida fue una combinación de sans-serif geométrica para títulos y
                    una legible para el cuerpo de texto.
                </p>

                <div class="blog-show-article__quote">
                    <blockquote>
                        "Necesitábamos que el sitio se viera tan grande como el evento. Wiquiweb lo logró en tiempo récord."
                    </blockquote>
                    <cite>— Organizador EFFIX 2026</cite>
                </div>

                <h2>Desarrollo y resultado</h2>
                <p>
                    El sitio se construyó en Laravel con un panel de administración liviano que permitía al equipo del
                    evento actualizar ponentes y agenda sin tocar código. Se integró una pasarela de pagos para el
                    registro de entradas y un sistema de confirmación por correo.
                </p>
                <p>
                    El resultado: más de 400 registros en los primeros tres días de publicación y cero incidencias
                    técnicas durante el evento.
                </p>

                <h2>Lo que aprendimos</h2>
                <p>
                    Proyectos con plazos cortos exigen tomar decisiones rápidas sin sacrificar calidad. La clave estuvo
                    en tener una arquitectura clara desde el principio y no agregar funcionalidades a mitad del proceso.
                    Cada hora que ahorramos en reuniones innecesarias la invertimos en código y diseño.
                </p>

                <!-- Tags -->
                <div class="blog-show-article__tags">
                    <span class="blog-show-article__tag">Diseño Web</span>
                    <span class="blog-show-article__tag">Laravel</span>
                    <span class="blog-show-article__tag">Eventos</span>
                    <span class="blog-show-article__tag">Caso de estudio</span>
                </div>

            </article>

            <!-- Sidebar -->
            <aside class="blog-show-sidebar">

                <div class="blog-show-sidebar__card">
                    <h3 class="blog-show-sidebar__title">Artículos recientes</h3>
                    <ul class="blog-show-sidebar__list">
                        <li class="blog-show-sidebar__item">
                            <a href="#" class="blog-show-sidebar__link">
                                <span class="blog-show-sidebar__link-category">SEO</span>
                                <span class="blog-show-sidebar__link-title">5 errores de SEO que están hundiendo tu página
                                    web</span>
                            </a>
                        </li>
                        <li class="blog-show-sidebar__item">
                            <a href="#" class="blog-show-sidebar__link">
                                <span class="blog-show-sidebar__link-category">Hosting</span>
                                <span class="blog-show-sidebar__link-title">¿Hosting en Colombia o en el exterior?</span>
                            </a>
                        </li>
                        <li class="blog-show-sidebar__item">
                            <a href="#" class="blog-show-sidebar__link">
                                <span class="blog-show-sidebar__link-category">Diseño Web</span>
                                <span class="blog-show-sidebar__link-title">Landing page vs. sitio web completo</span>
                            </a>
                        </li>
                        <li class="blog-show-sidebar__item">
                            <a href="#" class="blog-show-sidebar__link">
                                <span class="blog-show-sidebar__link-category">Marketing</span>
                                <span class="blog-show-sidebar__link-title">Por qué las redes sociales no reemplazan tu
                                    sitio web</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="blog-show-sidebar__card blog-show-sidebar__card--cta">
                    <div class="blog-show-sidebar__cta-icon">
                        <i data-lucide="globe"></i>
                    </div>
                    <h3 class="blog-show-sidebar__cta-title">¿Necesitas una página web?</h3>
                    <p class="blog-show-sidebar__cta-text">Cotiza tu proyecto con nosotros y recibe una propuesta en 24
                        horas.</p>
                    <a href="{{ route('contact') }}" class="blog-show-sidebar__cta-btn">
                        Hablar con un asesor
                        <i data-lucide="arrow-right"></i>
                    </a>
                </div>

            </aside>

        </div>
    </section>

    <!-- ════════════════ ARTÍCULOS RELACIONADOS ═══════════════ -->
    <section class="blog-show-related">
        <div class="blog-show-related__container">

            <div class="blog-show-related__header">
                <p class="blog-show-related__subtitle">Sigue leyendo</p>
                <h2 class="blog-show-related__title">Artículos <span
                        class="blog-show-related__highlight">relacionados</span></h2>
            </div>

            <div class="blog-show-related__grid">

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/seo-tips.webp') }}" alt="SEO" class="blog-post__image">
                        <span class="blog-post__category">SEO</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                8 de octubre, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                4 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">5 errores de SEO que están hundiendo tu página web</a>
                        </h3>
                        <p class="blog-post__excerpt">Muchas empresas pierden clientes potenciales por errores técnicos que
                            se pueden corregir en menos de una hora.</p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/landing-vs-web.webp') }}" alt="Landing vs Web"
                            class="blog-post__image">
                        <span class="blog-post__category">Diseño Web</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                22 de septiembre, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                3 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">Landing page vs. sitio web completo: ¿cuál necesita tu negocio?</a>
                        </h3>
                        <p class="blog-post__excerpt">No todos los negocios necesitan lo mismo. Te ayudamos a entender qué
                            presencia digital es la más adecuada.</p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/redes-sociales.webp') }}" alt="Redes sociales"
                            class="blog-post__image">
                        <span class="blog-post__category">Marketing Digital</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                10 de septiembre, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                5 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">Por qué las redes sociales no reemplazan a tu sitio web</a>
                        </h3>
                        <p class="blog-post__excerpt">Instagram y Facebook son herramientas poderosas, pero depender solo
                            de ellas es un riesgo enorme.</p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

            </div>

        </div>
    </section>

@endsection
