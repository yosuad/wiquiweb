@extends('layouts.app')

@section('title', 'Portafolio — Wiquiweb')

@push('styles')
    @vite('resources/css/pages/portfolio.css')
@endpush

@section('content')

    <!-- ════════════════ HERO ════════════════ -->
    <section class="portfolio-hero">
        <div class="portfolio-hero__container">
            <p class="portfolio-hero__subtitle">Nuestro trabajo</p>
            <h1 class="portfolio-hero__title">
                Proyectos que <span class="portfolio-hero__title-highlight">hablan por sí solos</span>
            </h1>
            <p class="portfolio-hero__description">
                Cada proyecto es una historia diferente. Aquí puedes ver lo que hemos construido
                y cómo ayudamos a cada cliente a lograr sus objetivos digitales.
            </p>
        </div>
    </section>

    <!-- ════════════════ GRID DE PROYECTOS ════════════════ -->
    <section class="portfolio-grid-section">
        <div class="portfolio-grid-section__container">
            <div class="portfolio-grid">

                {{-- Tu Libro en Casa --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/tulibroencasa.webp') }}"
                             alt="Tu Libro en Casa"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="#" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">E-commerce</span>
                            <span class="portfolio-card__tag">Diseño Gráfico</span>
                            <span class="portfolio-card__tag">Logo</span>
                        </div>
                        <h2 class="portfolio-card__title">Tu Libro en Casa</h2>
                        <p class="portfolio-card__text">Identidad de marca completa y tienda en línea para librería independiente. Desde el logo hasta la pasarela de pagos.</p>
                        <a href="#" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Enlace Tropical --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/enlacetropical.webp') }}"
                             alt="Enlace Tropical"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="https://enlacetropical.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">Identidad de Marca</span>
                            <span class="portfolio-card__tag">Diseño Web</span>
                        </div>
                        <h2 class="portfolio-card__title">Enlace Tropical</h2>
                        <p class="portfolio-card__text">Rediseño de identidad visual y desarrollo web para emisora comunitaria con presencia en múltiples plataformas digitales.</p>
                        <a href="https://enlacetropical.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Persianas y Cortinas Valencia --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/persianasycortinasvalencia.webp') }}"
                             alt="Persianas y Cortinas Valencia"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="https://wiquiweb.co/persianasycortinasvalencia" target="_blank" rel="noopener noreferrer" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">Landing Page</span>
                        </div>
                        <h2 class="portfolio-card__title">Persianas y Cortinas Valencia</h2>
                        <p class="portfolio-card__text">Landing page optimizada para conversión de negocio local de persianas y cortinas.</p>
                        <a href="https://wiquiweb.co/persianasycortinasvalencia" target="_blank" rel="noopener noreferrer" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Canal Zona 6 TV --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/canalzona6tv.webp') }}"
                             alt="Canal Zona 6 TV"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="https://wiquiweb.co/canalzona6tv" target="_blank" rel="noopener noreferrer" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">Landing Page</span>
                        </div>
                        <h2 class="portfolio-card__title">Canal Zona 6 TV</h2>
                        <p class="portfolio-card__text">Landing page para canal de televisión comunitario con información de programación y cobertura.</p>
                        <a href="https://wiquiweb.co/canalzona6tv" target="_blank" rel="noopener noreferrer" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Emisora Radio Visual --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/radiovisual.webp') }}"
                             alt="Emisora Radio Visual"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="https://www.emisoraradiovisual.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">Streaming</span>
                            <span class="portfolio-card__tag">Diseño Web</span>
                        </div>
                        <h2 class="portfolio-card__title">Emisora Radio Visual</h2>
                        <p class="portfolio-card__text">Sitio web con reproductor de streaming integrado para emisora de radio online.</p>
                        <a href="https://www.emisoraradiovisual.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

                {{-- Las 10 Noticias --}}
                <article class="portfolio-card">
                    <div class="portfolio-card__image-wrapper">
                        <img src="{{ asset('img/portafolio/las10noticiasmasbuscadas.webp') }}"
                             alt="Las 10 Noticias Más Buscadas"
                             class="portfolio-card__image"
                             loading="lazy">
                        <div class="portfolio-card__overlay">
                            <a href="https://las10noticiasmasbuscadas.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__btn">
                                <i data-lucide="eye" aria-hidden="true"></i>
                                Ver proyecto
                            </a>
                        </div>
                    </div>
                    <div class="portfolio-card__body">
                        <div class="portfolio-card__tags">
                            <span class="portfolio-card__tag">Diseño Web</span>
                            <span class="portfolio-card__tag">Noticias</span>
                        </div>
                        <h2 class="portfolio-card__title">Las 10 Noticias Más Buscadas</h2>
                        <p class="portfolio-card__text">Portal de noticias con diseño editorial moderno y sistema de publicación de contenido.</p>
                        <a href="https://las10noticiasmasbuscadas.com" target="_blank" rel="noopener noreferrer" class="portfolio-card__link">
                            Ver proyecto <i data-lucide="arrow-right" aria-hidden="true"></i>
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </section>

@endsection