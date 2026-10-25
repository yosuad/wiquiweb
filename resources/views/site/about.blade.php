@extends('layouts.app')

@section('title', 'Nosotros')

@section('content')

    <!-- ════════════════ HERO ═══════════════ -->
    <section class="about-hero">
        <div class="about-hero__container">

            <div class="about-hero__image-wrapper">
                <img src="{{ asset('img/nosotros/equipo.webp') }}" alt="Equipo WiquiWeb" class="about-hero__image">
                <div class="about-hero__badge">
                    <span class="about-hero__badge-number">+{{ $anos }}</span>
                    <span class="about-hero__badge-label">años de experiencia</span>
                </div>
            </div>

            <div class="about-hero__content">
                <p class="about-hero__subtitle">Quiénes Somos</p>
                <h1 class="about-hero__title">
                    La agencia que hace crecer <span class="about-hero__highlight">tu negocio</span> en digital
                </h1>
                <p class="about-hero__text">
                    Somos WiquiWeb, un equipo apasionado por el diseño y la tecnología.<br>
                    Llevamos más de 10 años transformando ideas en presencias digitales poderosas.
                </p>
                <div class="about-hero__actions">
                    <a href="#equipo" class="about-hero__btn about-hero__btn--primary">Conoce al equipo</a>
                    <a href="/#servicios" class="about-hero__btn about-hero__btn--secondary">Nuestros servicios</a>
                </div>
            </div>

        </div>
    </section>

    <!-- ═══════════════ MISIÓN VISIÓN VALORES ═══════════════ -->
    <section class="about-mv">
        <div class="about-mv__container">
            <div class="about-mv__grid">

                <article class="about-mv__card">
                    <div class="about-mv__card-header">
                        <div class="about-mv__card-icon">
                            <i data-lucide="target"></i>
                        </div>
                        <h3 class="about-mv__card-title">Nuestra Misión</h3>
                    </div>
                    <p class="about-mv__card-text">
                        Empoderar a empresas y emprendedores con soluciones digitales a medida: páginas web modernas,
                        identidad visual sólida y herramientas tecnológicas que impulsan su crecimiento, haciendo
                        accesible la transformación digital sin importar el tamaño del negocio.
                    </p>
                </article>

                <article class="about-mv__card">
                    <div class="about-mv__card-header">
                        <div class="about-mv__card-icon">
                            <i data-lucide="eye"></i>
                        </div>
                        <h3 class="about-mv__card-title">Nuestra Visión</h3>
                    </div>
                    <p class="about-mv__card-text">
                        Ser la agencia digital de referencia en Latinoamérica, reconocida por transformar negocios
                        reales con creatividad, tecnología y compromiso humano, construyendo relaciones duraderas
                        basadas en resultados concretos y confianza mutua.
                    </p>
                </article>

                <article class="about-mv__card">
                    <div class="about-mv__card-header">
                        <div class="about-mv__card-icon">
                            <i data-lucide="heart"></i>
                        </div>
                        <h3 class="about-mv__card-title">Nuestros Valores</h3>
                    </div>
                    <ul class="about-mv__values">
                        <li class="about-mv__value">
                            <i data-lucide="check-circle"></i>
                            Compromiso con el cliente
                        </li>
                        <li class="about-mv__value">
                            <i data-lucide="check-circle"></i>
                            Creatividad sin límites
                        </li>
                        <li class="about-mv__value">
                            <i data-lucide="check-circle"></i>
                            Transparencia total
                        </li>
                        <li class="about-mv__value">
                            <i data-lucide="check-circle"></i>
                            Calidad en cada detalle
                        </li>
                        <li class="about-mv__value">
                            <i data-lucide="check-circle"></i>
                            Innovación constante
                        </li>
                    </ul>
                </article>

            </div>
        </div>
    </section>

    <!-- ═══════════════ STATS ═══════════════ -->
    <section class="about-stats">
        <div class="about-stats__container">

            <div class="about-stat">
                <div class="about-stat__icon"><i data-lucide="calendar"></i></div>
                <span class="about-stat__count">+{{ $anos }}</span>
                <p class="about-stat__label">Años de experiencia</p>
            </div>

            <div class="about-stat">
                <div class="about-stat__icon"><i data-lucide="briefcase"></i></div>
                <span class="about-stat__count">+{{ $proyectos }}</span>
                <p class="about-stat__label">Proyectos realizados</p>
            </div>

            <div class="about-stat">
                <div class="about-stat__icon"><i data-lucide="heart"></i></div>
                <span class="about-stat__count">+{{ $clientes }}</span>
                <p class="about-stat__label">Clientes satisfechos</p>
            </div>

            <div class="about-stat">
                <div class="about-stat__icon"><i data-lucide="users"></i></div>
                <span class="about-stat__count">+{{ $colaborativos }}</span>
                <p class="about-stat__label">Colaboradores</p>
            </div>

        </div>
    </section>

    <!-- ═══════════════ HISTORIA ═══════════════ -->
    <section class="about-story">
        <div class="about-story__container">

            <div class="about-story__header">
                <p class="about-story__subtitle">Nuestra Historia</p>
                <h2 class="about-story__title">De una idea a <span class="about-story__title-highlight">cientos de proyectos</span></h2>
            </div>

            <div class="about-story__grid">

                <div class="about-story__text">
                    <p class="about-story__paragraph">
                        WiquiWeb nació hace más de una década con una idea simple pero poderosa: que toda empresa,
                        sin importar su tamaño, merece tener una presencia digital profesional. Lo que comenzó
                        como un proyecto freelance se convirtió en una agencia completa con equipo dedicado.
                    </p>
                    <p class="about-story__paragraph">
                        A lo largo de los años hemos aprendido, crecido y evolucionado junto a nuestros clientes.
                        Cada proyecto ha sido una lección, cada cliente una alianza. Hoy somos el resultado de
                        esa experiencia acumulada y del compromiso que ponemos en cada trabajo.
                    </p>
                    <p class="about-story__paragraph">
                        Trabajamos con empresas de medios, comercios locales, emprendedores y organizaciones
                        culturales en toda Colombia y Latinoamérica. Cada historia es diferente, y por eso
                        cada solución que ofrecemos es única.
                    </p>
                </div>

                <div class="about-story__timeline">

                    <div class="about-timeline__item">
                        <div class="about-timeline__dot"></div>
                        <div class="about-timeline__body">
                            <span class="about-timeline__year">2014</span>
                            <h3 class="about-timeline__title">Los primeros pasos</h3>
                            <p class="about-timeline__text">Primeros proyectos de diseño web para clientes locales en Colombia.</p>
                        </div>
                    </div>

                    <div class="about-timeline__item">
                        <div class="about-timeline__dot"></div>
                        <div class="about-timeline__body">
                            <span class="about-timeline__year">2017</span>
                            <h3 class="about-timeline__title">Crecimiento del equipo</h3>
                            <p class="about-timeline__text">Incorporamos diseñadores, desarrolladores y un equipo de marketing.</p>
                        </div>
                    </div>

                    <div class="about-timeline__item">
                        <div class="about-timeline__dot"></div>
                        <div class="about-timeline__body">
                            <span class="about-timeline__year">2020</span>
                            <h3 class="about-timeline__title">Expansión de servicios</h3>
                            <p class="about-timeline__text">Sumamos hosting, correos corporativos y marketing digital a nuestra oferta.</p>
                        </div>
                    </div>

                    <div class="about-timeline__item">
                        <div class="about-timeline__dot"></div>
                        <div class="about-timeline__body">
                            <span class="about-timeline__year">2024</span>
                            <h3 class="about-timeline__title">Hoy</h3>
                            <p class="about-timeline__text">Más de 500 clientes satisfechos y proyectos en toda Latinoamérica.</p>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════ EQUIPO ═══════════════ -->
    <section id="equipo" class="about-team">
        <div class="about-team__container">

            <div class="about-team__header">
                <p class="about-team__subtitle">Las personas detrás</p>
                <h2 class="about-team__title">Nuestro <span class="about-team__title-highlight">Equipo</span></h2>
                <p class="about-team__description">Profesionales apasionados por crear experiencias digitales que marcan la diferencia.</p>
            </div>

            <div class="about-team__grid">

                <article class="about-member">
                    <div class="about-member__image-wrapper">
                        <img src="{{ asset('img/team/member1.webp') }}" alt="Fundador WiquiWeb" class="about-member__image">
                        <div class="about-member__social">
                            <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="about-member__social-link" aria-label="LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="about-member__body">
                        <h3 class="about-member__name">Nombre del Fundador</h3>
                        <span class="about-member__role">CEO & Fundador</span>
                        <p class="about-member__bio">Visionario digital con más de 10 años transformando negocios a través del diseño y la tecnología.</p>
                    </div>
                </article>

                <article class="about-member">
                    <div class="about-member__image-wrapper">
                        <img src="{{ asset('img/team/member2.webp') }}" alt="Diseñador Web" class="about-member__image">
                        <div class="about-member__social">
                            <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="about-member__social-link" aria-label="LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="about-member__body">
                        <h3 class="about-member__name">Nombre del Diseñador</h3>
                        <span class="about-member__role">Diseñador Web Senior</span>
                        <p class="about-member__bio">Especialista en UX/UI con pasión por crear interfaces elegantes y funcionales que enamoran al usuario.</p>
                    </div>
                </article>

                <article class="about-member">
                    <div class="about-member__image-wrapper">
                        <img src="{{ asset('img/team/member3.webp') }}" alt="Desarrolladora" class="about-member__image">
                        <div class="about-member__social">
                            <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="about-member__social-link" aria-label="LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="about-member__body">
                        <h3 class="about-member__name">Nombre Desarrolladora</h3>
                        <span class="about-member__role">Desarrolladora Frontend</span>
                        <p class="about-member__bio">Código limpio y rendimiento optimizado. Convierte diseños en experiencias web rápidas y accesibles.</p>
                    </div>
                </article>

                <article class="about-member">
                    <div class="about-member__image-wrapper">
                        <img src="{{ asset('img/team/member4.webp') }}" alt="Marketing Digital" class="about-member__image">
                        <div class="about-member__social">
                            <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="about-member__social-link" aria-label="LinkedIn">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/></svg>
                            </a>
                        </div>
                    </div>
                    <div class="about-member__body">
                        <h3 class="about-member__name">Nombre Estratega</h3>
                        <span class="about-member__role">Estratega de Marketing</span>
                        <p class="about-member__bio">Conecta marcas con sus audiencias usando estrategias digitales basadas en datos y creatividad.</p>
                    </div>
                </article>

            </div>
        </div>
    </section>

    <!-- ═══════════════ POR QUÉ NOSOTROS ═══════════════ -->
    <section class="about-why">
        <div class="about-why__container">

            <div class="about-why__header">
                <p class="about-why__subtitle">Nuestra Diferencia</p>
                <h2 class="about-why__title">Por qué trabajar <span class="about-why__title-highlight">con nosotros</span></h2>
                <p class="about-why__description">Más que proveedores, somos el aliado estratégico que tu negocio necesita para crecer en digital.</p>
            </div>

            <div class="about-why__grid">

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="handshake"></i></div>
                    <h3 class="about-why__card-title">Trato Personalizado</h3>
                    <p class="about-why__card-text">Cada cliente es único. Nos tomamos el tiempo de entender tu negocio antes de proponer cualquier solución.</p>
                </div>

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="zap"></i></div>
                    <h3 class="about-why__card-title">Entrega Rápida</h3>
                    <p class="about-why__card-text">Proyectos bien planificados que se entregan en los tiempos acordados, sin excusas ni sorpresas.</p>
                </div>

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="shield-check"></i></div>
                    <h3 class="about-why__card-title">Calidad Garantizada</h3>
                    <p class="about-why__card-text">Cada pixel, cada línea de código y cada estrategia pasa por un control de calidad estricto antes de llegar a tus manos.</p>
                </div>

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="headphones"></i></div>
                    <h3 class="about-why__card-title">Soporte Continuo</h3>
                    <p class="about-why__card-text">No desaparecemos al terminar el proyecto. Estamos disponibles para soporte, actualizaciones y mejoras.</p>
                </div>

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="trending-up"></i></div>
                    <h3 class="about-why__card-title">Resultados Medibles</h3>
                    <p class="about-why__card-text">Trabajamos orientados a resultados: más visitas, más clientes, más ventas. Eso es lo que realmente importa.</p>
                </div>

                <div class="about-why__card">
                    <div class="about-why__card-icon"><i data-lucide="globe"></i></div>
                    <h3 class="about-why__card-title">Presencia Global</h3>
                    <p class="about-why__card-text">Clientes en Colombia y toda Latinoamérica. Experiencia multicultural y entendimiento del mercado regional.</p>
                </div>

            </div>
        </div>
    </section>

    <!-- ═══════════════ CTA ═══════════════ -->
    <section class="about-cta">
        <div class="about-cta__container">
            <div class="about-cta__content">
                <p class="about-cta__label">¿Listo para empezar?</p>
                <h2 class="about-cta__title">Hagamos crecer tu negocio <span class="about-cta__highlight">juntos</span></h2>
                <p class="about-cta__text">Contáctanos hoy y recibe una consulta gratuita sobre tu proyecto digital.</p>
                <div class="about-cta__actions">
                    <a href="{{ route('home') }}#contacto" class="about-cta__btn about-cta__btn--primary">Hablar con nosotros</a>
                    <a href="{{ route('services.web-design') }}" class="about-cta__btn about-cta__btn--secondary">Ver servicios</a>
                </div>
            </div>
        </div>
    </section>

@endsection