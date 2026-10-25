@extends('layouts.app')

@section('title', 'Blog')

@section('content')

    <!-- ════════════════ BLOG HERO ═══════════════ -->
    <section class="blog-hero">
        <div class="blog-hero__content">
            <p class="blog-hero__subtitle wow fadeInUp">Recursos y consejos</p>
            <h1 class="blog-hero__title wow fadeInUp">
                Nuestro <span class="blog-hero__highlight">Blog</span>
            </h1>
            <p class="blog-hero__text wow fadeInDown">
                Aprende sobre diseño web, marketing digital y tecnología<br>
                para hacer crecer tu negocio en línea
            </p>
        </div>
    </section>

    <!-- ════════════════ FILTROS ═══════════════ -->
    <section class="blog-filters">
        <div class="blog-filters__container">
            <ul class="blog-filters__list">
                <li>
                    <a href="#" class="blog-filters__tag blog-filters__tag--active">Todos</a>
                </li>
                <li>
                    <a href="#" class="blog-filters__tag">Diseño Web</a>
                </li>
                <li>
                    <a href="#" class="blog-filters__tag">Marketing Digital</a>
                </li>
                <li>
                    <a href="#" class="blog-filters__tag">Hosting</a>
                </li>
                <li>
                    <a href="#" class="blog-filters__tag">SEO</a>
                </li>
                <li>
                    <a href="#" class="blog-filters__tag">Negocios</a>
                </li>
            </ul>
        </div>
    </section>

    <!-- ════════════════ ARTÍCULO DESTACADO ═══════════════ -->
    <section class="blog-featured">
        <div class="blog-featured__container">
            <article class="blog-featured__card wow fadeInUp">
                <div class="blog-featured__image-wrapper">
                    <img src="{{ asset('img/blog/effix-2026.webp') }}" alt="EFFIX 2026" class="blog-featured__image">
                    <span class="blog-featured__badge">Destacado</span>
                </div>
                <div class="blog-featured__body">
                    <div class="blog-featured__meta">
                        <span class="blog-featured__category">Diseño Web</span>
                        <span class="blog-featured__dot">·</span>
                        <time class="blog-featured__date">15 de octubre, 2026</time>
                        <span class="blog-featured__dot">·</span>
                        <span class="blog-featured__read">5 min de lectura</span>
                    </div>
                    <h2 class="blog-featured__title">
                        EFFIX 2026: Cómo diseñamos la plataforma digital del evento
                    </h2>
                    <p class="blog-featured__excerpt">
                        Descubre el proceso detrás del diseño y desarrollo del sitio web para EFFIX 2026,
                        el festival de experiencias empresariales más importante de la región. Desde la
                        arquitectura de información hasta la estrategia de contenidos.
                    </p>
                    <div class="blog-featured__footer">
                        <div class="blog-featured__author">
                            <div class="blog-featured__author-avatar">
                                <i data-lucide="user"></i>
                            </div>
                            <span class="blog-featured__author-name">Equipo Wiquiweb</span>
                        </div>
                        <a href="#" class="blog-featured__link">
                            Leer artículo
                            <i class="blog-featured__link-icon" data-lucide="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </article>
        </div>
    </section>

    <!-- ════════════════ GRID DE ARTÍCULOS ═══════════════ -->
    <section class="blog-grid">
        <div class="blog-grid__container">

            <div class="blog-grid__header">
                <p class="blog-grid__subtitle">Últimas publicaciones</p>
                <h2 class="blog-grid__title">Más artículos del <span class="blog-grid__title-highlight">Blog</span></h2>
            </div>

            <div class="blog-grid__posts">

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/seo-tips.webp') }}" alt="SEO para pequeñas empresas"
                            class="blog-post__image">
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
                        <p class="blog-post__excerpt">
                            Muchas empresas pierden clientes potenciales por errores técnicos que se pueden corregir en
                            menos de una hora. Te contamos cuáles son.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/hosting-colombia.webp') }}" alt="Hosting en Colombia"
                            class="blog-post__image">
                        <span class="blog-post__category">Hosting</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                1 de octubre, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                6 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">¿Hosting en Colombia o en el exterior? Lo que nadie te dice</a>
                        </h3>
                        <p class="blog-post__excerpt">
                            La ubicación del servidor afecta la velocidad de carga y el posicionamiento local. Analizamos
                            las ventajas y desventajas para tu negocio.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/landing-vs-web.webp') }}" alt="Landing page vs sitio web"
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
                        <p class="blog-post__excerpt">
                            No todos los negocios necesitan lo mismo. Te ayudamos a entender qué tipo de presencia digital
                            es la más adecuada para tu etapa actual.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/redes-sociales.webp') }}" alt="Redes sociales y sitio web"
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
                        <p class="blog-post__excerpt">
                            Instagram y Facebook son herramientas poderosas, pero depender solo de ellas es un riesgo
                            enorme. Tu web es el único activo digital que realmente es tuyo.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/velocidad-web.webp') }}" alt="Velocidad de carga"
                            class="blog-post__image">
                        <span class="blog-post__category">SEO</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                28 de agosto, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                7 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">Velocidad de carga: el factor que Google premia (y tus clientes también)</a>
                        </h3>
                        <p class="blog-post__excerpt">
                            Un sitio lento pierde hasta el 40% de sus visitantes antes de cargar. Descubre cómo optimizar la
                            velocidad sin necesitar ser desarrollador.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

                <article class="blog-post wow fadeInUp">
                    <a href="#" class="blog-post__image-wrapper">
                        <img src="{{ asset('img/blog/correo-corporativo.webp') }}" alt="Correo corporativo"
                            class="blog-post__image">
                        <span class="blog-post__category">Negocios</span>
                    </a>
                    <div class="blog-post__body">
                        <div class="blog-post__meta">
                            <time class="blog-post__date">
                                <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                15 de agosto, 2026
                            </time>
                            <span class="blog-post__read">
                                <i data-lucide="clock" class="blog-post__meta-icon"></i>
                                3 min
                            </span>
                        </div>
                        <h3 class="blog-post__title">
                            <a href="#">Correo corporativo: la diferencia entre parecer un negocio serio y uno
                                amateur</a>
                        </h3>
                        <p class="blog-post__excerpt">
                            Enviar cotizaciones desde un @gmail.com o @hotmail.com puede estar costándote más clientes de lo
                            que crees. Te explicamos por qué y cómo cambiarlo hoy.
                        </p>
                        <a href="#" class="blog-post__link">
                            Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                        </a>
                    </div>
                </article>

            </div>

            <!-- Paginación -->
            <div class="blog-grid__pagination">
                <a href="#" class="blog-pagination__btn blog-pagination__btn--prev" aria-label="Página anterior">
                    <i data-lucide="chevron-left"></i>
                </a>
                <a href="#" class="blog-pagination__page blog-pagination__page--active">1</a>
                <a href="#" class="blog-pagination__page">2</a>
                <a href="#" class="blog-pagination__page">3</a>
                <span class="blog-pagination__dots">…</span>
                <a href="#" class="blog-pagination__page">8</a>
                <a href="#" class="blog-pagination__btn blog-pagination__btn--next" aria-label="Página siguiente">
                    <i data-lucide="chevron-right"></i>
                </a>
            </div>

        </div>
    </section>

    <!-- ════════════════ NEWSLETTER ═══════════════ -->
    <section class="blog-newsletter">
        <div class="blog-newsletter__container wow fadeInUp">
            <div class="blog-newsletter__icon">
                <i data-lucide="mail"></i>
            </div>
            <div class="blog-newsletter__body">
                <h2 class="blog-newsletter__title">Recibe los mejores artículos en tu correo</h2>
                <p class="blog-newsletter__text">Sin spam. Solo contenido útil para hacer crecer tu negocio digital.</p>
                <form class="blog-newsletter__form" action="#" method="POST">
                    @csrf
                    <input type="email" name="email" class="blog-newsletter__input"
                        placeholder="tucorreo@empresa.com" required aria-label="Correo electrónico">
                    <button type="submit" class="blog-newsletter__btn">
                        Suscribirme
                        <i data-lucide="send" class="blog-newsletter__btn-icon"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection
