@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- ════════════════ BANNER ═══════════════ -->
    <section class="home-banner">

        <nav class="home-banner__menu" aria-label="Redes sociales">
            <ul class="home-banner__menu-list">
                <li class="home-banner__menu-divider"></li>
                <li class="home-banner__menu-item">
                    <a href="https://www.facebook.com/wiquieb" target="_blank" class="home-banner__menu-link" aria-label="Facebook">
                        <i class="home-banner__menu-icon fa-brands fa-facebook-f" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="home-banner__menu-item">
                    <a href="https://www.instagram.com/wiquiweb" target="_blank" class="home-banner__menu-link" aria-label="Instagram">
                        <i class="home-banner__menu-icon fa-brands fa-instagram" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="home-banner__menu-item">
                    <a href="https://www.tiktok.com/@wiquiweb" target="_blank" class="home-banner__menu-link" aria-label="TikTok">
                        <i class="home-banner__menu-icon fa-brands fa-tiktok" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="home-banner__menu-item">
                    <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="home-banner__menu-link" aria-label="LinkedIn">
                        <i class="home-banner__menu-icon fa-brands fa-linkedin-in" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="home-banner__menu-item">
                    <a href="https://www.youtube.com/@wiquiweb" target="_blank" class="home-banner__menu-link" aria-label="YouTube">
                        <i class="home-banner__menu-icon fa-brands fa-youtube" aria-hidden="true"></i>
                    </a>
                </li>
                <li class="home-banner__menu-divider"></li>
            </ul>
        </nav>

        <div class="home-banner__content">
            <h1 class="home-banner__subtitle wow fadeInUp">Páginas web</h1>
            <h2 class="home-banner__title wow fadeInUp">
                Hosting <span class="home-banner__highlight">y Correos</span>
            </h2>
            <p class="home-banner__text wow fadeInDown">
                Diseño profesional para impulsar tu presencia digital
                <br>
                desde el primer clic
            </p>
            <div class="home-banner__actions">
                <a href="{{ route('services.web-design') }}" class="home-banner__btn home-banner__btn--primary wow fadeInLeft">Quiero mi web</a>
                <a href="#" class="home-banner__btn home-banner__btn--secondary wow fadeInRight">Hablar con un
                    asesor</a>
            </div>
        </div>

        <div class="home-banner__video-wrapper">
            <video class="home-banner__video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/banner-video.mp4') }}" type="video/mp4">
            </video>
        </div>

    </section>

    <!-- ═══════════════ CLIENT LOGOS ═══════════════ -->
    <section class="clients">
        <div class="clients__container">
            <p class="clients__label">Empresas que confían en nosotros</p>
            <div class="clients__track-wrapper">
                <div class="clients__track">
                    <div class="clients__item"><span>PT</span></div>
                    <div class="clients__item"><span>MM</span></div>
                    <div class="clients__item"><span>AD</span></div>
                    <div class="clients__item"><span>CL</span></div>
                    <div class="clients__item"><span>TS</span></div>
                    <div class="clients__item"><span>RG</span></div>
                    <div class="clients__item"><span>SD</span></div>
                    <div class="clients__item"><span>AM</span></div>
                    <div class="clients__item"><span>PT</span></div>
                    <div class="clients__item"><span>MM</span></div>
                    <div class="clients__item"><span>AD</span></div>
                    <div class="clients__item"><span>CL</span></div>
                    <div class="clients__item"><span>TS</span></div>
                    <div class="clients__item"><span>RG</span></div>
                    <div class="clients__item"><span>SD</span></div>
                    <div class="clients__item"><span>AM</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ SERVICES ═══════════════ -->
    <section id="servicios" class="services">
        <div class="services__container">
            <div class="services__header">
                <p class="services__subtitle">¿Qué Podemos hacer por ti?</p>
                <h2 class="services__title">Servicios que te <span class="services__title-highlight">Pueden ayudar</span>
                </h2>
            </div>
            <div class="services__grid">
                <article class="card">
                    <div class="card__icon"><i data-lucide="globe"></i></div>
                    <h3 class="card__title">Diseño Web</h3>
                    <p class="card__text">Creamos páginas web modernas, responsivas y optimizadas para buscadores. Diseños
                        personalizados que reflejan la identidad de tu marca y conectan con tu audiencia.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
                <article class="card">
                    <div class="card__icon"><i data-lucide="palette"></i></div>
                    <h3 class="card__title">Diseño Gráfico</h3>
                    <p class="card__text">Diseño de identidad corporativa, logotipos, material publicitario y todo lo que
                        necesitas para potenciar la imagen visual de tu empresa.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
                <article class="card">
                    <div class="card__icon"><i data-lucide="building-2"></i></div>
                    <h3 class="card__title">Gestión Empresarial</h3>
                    <p class="card__text">Administración completa de servicios de hosting, dominios y configuración de
                        correos corporativos para mantener tu negocio siempre en línea.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
                <article class="card">
                    <div class="card__icon"><i data-lucide="mail"></i></div>
                    <h3 class="card__title">Correos Corporativos</h3>
                    <p class="card__text">Configuración profesional de correos empresariales con tu dominio. Seguridad,
                        capacidad y soporte técnico incluido.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
                <article class="card">
                    <div class="card__icon"><i data-lucide="monitor-smartphone"></i></div>
                    <h3 class="card__title">Actualizaciones Web</h3>
                    <p class="card__text">Mantenimiento y actualización constante de tu sitio web. Contenido fresco,
                        seguridad mejorada y rendimiento optimizado.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
                <article class="card">
                    <div class="card__icon"><i data-lucide="megaphone"></i></div>
                    <h3 class="card__title">Marketing Digital</h3>
                    <p class="card__text">Estrategias de marketing digital, gestión de redes sociales y campañas
                        publicitarias para aumentar tu visibilidad online.</p>
                    <a href="#" class="card__link">
                        Leer más
                        <i class="card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>
            </div>
        </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="why-us">
        <div class="why-us__container">
            <div class="why-us__header">
                <p class="why-us__subtitle">Nuestra Diferencia</p>
                <h2 class="why-us__title">¿Por qué <span class="why-us__title-highlight">Elegirnos?</span></h2>
                <p class="why-us__description">Combinamos creatividad, tecnología y compromiso para llevar tu negocio al
                    siguiente nivel digital.</p>
            </div>
            <div class="why-us__grid">
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="zap"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">Rápido y Eficiente</h3>
                        <p class="feature-card__text">Entregamos proyectos en tiempo récord sin sacrificar calidad.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="shield"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">Seguridad Garantizada</h3>
                        <p class="feature-card__text">Protegemos tu sitio con las mejores prácticas de seguridad web.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="heart-handshake"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">Soporte Personalizado</h3>
                        <p class="feature-card__text">Atención directa y personalizada para resolver todas tus dudas.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="clock"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">Disponibilidad 24/7</h3>
                        <p class="feature-card__text">Tu sitio siempre en línea con monitoreo constante.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="award"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">+10 Años de Experiencia</h3>
                        <p class="feature-card__text">Conocimiento probado en diseño y desarrollo web.</p>
                    </div>
                </div>
                <div class="feature-card">
                    <div class="feature-card__icon"><i data-lucide="check-circle"></i></div>
                    <div class="feature-card__body">
                        <h3 class="feature-card__title">Resultados Comprobados</h3>
                        <p class="feature-card__text">Más de 500 clientes satisfechos respaldan nuestro trabajo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ WORK PROCESS ═══════════════ -->
    <section class="process">
        <div class="process__container">
            <div class="process__header">
                <p class="process__subtitle">Cómo Trabajamos</p>
                <h2 class="process__title">Nuestro <span class="process__title-highlight">Proceso</span></h2>
                <p class="process__description">Un proceso claro y transparente para convertir tus ideas en realidad.</p>
            </div>
            <div class="process__grid">
                <div class="process__line"></div>
                <div class="step">
                    <div class="step__number-bg">01</div>
                    <div class="step__icon">
                        <i data-lucide="message-square"></i>
                        <span class="step__badge">01</span>
                    </div>
                    <h3 class="step__title">Consulta</h3>
                    <p class="step__text">Escuchamos tus ideas, objetivos y necesidades para entender tu visión.</p>
                </div>
                <div class="step">
                    <div class="step__number-bg">02</div>
                    <div class="step__icon">
                        <i data-lucide="pen-tool"></i>
                        <span class="step__badge">02</span>
                    </div>
                    <h3 class="step__title">Diseño</h3>
                    <p class="step__text">Creamos mockups y prototipos que reflejan la identidad de tu marca.</p>
                </div>
                <div class="step">
                    <div class="step__number-bg">03</div>
                    <div class="step__icon">
                        <i data-lucide="code"></i>
                        <span class="step__badge">03</span>
                    </div>
                    <h3 class="step__title">Desarrollo</h3>
                    <p class="step__text">Convertimos el diseño en código limpio, optimizado y funcional.</p>
                </div>
                <div class="step">
                    <div class="step__number-bg">04</div>
                    <div class="step__icon">
                        <i data-lucide="rocket"></i>
                        <span class="step__badge">04</span>
                    </div>
                    <h3 class="step__title">Lanzamiento</h3>
                    <p class="step__text">Publicamos tu sitio y te brindamos soporte continuo.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ PORTFOLIO ═══════════════ -->
    <section id="portafolio" class="portfolio">
        <div class="portfolio__container">
            <div class="portfolio__header">
                <p class="portfolio__subtitle">Nuestro Trabajo</p>
                <h2 class="portfolio__title">Proyectos <span class="portfolio__title-highlight">Destacados</span></h2>
                <p class="portfolio__description">Una muestra de nuestros mejores trabajos y casos de éxito.</p>
            </div>
            <div class="portfolio__grid">
                <a href="#" class="project">
                    <img src="images/project1.jpg" alt="Periódico El Taller" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">Diseño Web</span>
                        <h3 class="project__title">Periódico El Taller</h3>
                    </div>
                </a>
                <a href="#" class="project">
                    <img src="images/project2.jpg" alt="Mesa de Medios" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">Identidad Corporativa</span>
                        <h3 class="project__title">Mesa de Medios</h3>
                    </div>
                </a>
                <a href="#" class="project">
                    <img src="images/project3.jpg" alt="A Todo Deporte" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">E-commerce</span>
                        <h3 class="project__title">A Todo Deporte</h3>
                    </div>
                </a>
                <a href="#" class="project">
                    <img src="images/project4.jpg" alt="Consultora Legal" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">Diseño Web</span>
                        <h3 class="project__title">Consultora Legal</h3>
                    </div>
                </a>
                <a href="#" class="project">
                    <img src="images/project5.jpg" alt="Restaurante Gourmet" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">Branding</span>
                        <h3 class="project__title">Restaurante Gourmet</h3>
                    </div>
                </a>
                <a href="#" class="project">
                    <img src="images/project6.jpg" alt="Tech Startup" class="project__image">
                    <div class="project__overlay"></div>
                    <div class="project__content">
                        <span class="project__category">Aplicación Web</span>
                        <h3 class="project__title">Tech Startup</h3>
                    </div>
                </a>
            </div>
            <div class="portfolio__cta">
                <a href="#" class="portfolio__btn">Ver todos los proyectos</a>
            </div>
        </div>
    </section>

    <!-- ═══════════════ STATS ═══════════════ -->
    <section class="stats">
        <div class="stats__container">
            <div class="stats__header">
                <p class="stats__subtitle">Agencia de Diseño y Desarrollo</p>
                <h2 class="stats__title">Estadísticas de trabajos <span class="stats__title-highlight">Realizados</span>
                </h2>
                <p class="stats__description">Aquí puedes encontrar un resumen de nuestras estadísticas durante estos años
                    de trabajo.</p>
            </div>
            <div class="stats__grid">
                <div class="stat">
                    <div class="stat__icon"><i data-lucide="calendar"></i></div>
                    <span class="stat__count">+10</span>
                    <h3 class="stat__label">Período de Actividad</h3>
                </div>
                <div class="stat">
                    <div class="stat__icon"><i data-lucide="briefcase"></i></div>
                    <span class="stat__count">+45</span>
                    <h3 class="stat__label">Proyectos realizados</h3>
                </div>
                <div class="stat">
                    <div class="stat__icon"><i data-lucide="users"></i></div>
                    <span class="stat__count">+20</span>
                    <h3 class="stat__label">Trabajo colaborativo</h3>
                </div>
                <div class="stat">
                    <div class="stat__icon"><i data-lucide="heart"></i></div>
                    <span class="stat__count">+500</span>
                    <h3 class="stat__label">Clientes Contentos</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ REVIEWS ═══════════════ -->
    <section id="testimonios" class="reviews">
        <div class="reviews__container">
            <div class="reviews__header">
                <p class="reviews__subtitle">Reseñas</p>
                <h2 class="reviews__title">Qué dicen nuestros <span class="reviews__title-highlight">Clientes?</span></h2>
                <p class="reviews__description">Nuestros clientes siempre salen satisfechos con sus webs y apps.</p>
            </div>
            <div class="reviews__grid">
                <article class="review-card">
                    <img src="images/user1.jpg" alt="Jorge Mario Escobar" class="review-card__avatar">
                    <div class="review-card__body">
                        <span class="review-card__company">Periódico el Taller</span>
                        <h3 class="review-card__name">Jorge Mario Escobar</h3>
                        <p class="review-card__text">Destacamos en la red gracias a su eficaz capacitación y asesoría
                            constante, permitiéndonos gestionar la página de forma autónoma.</p>
                        <button class="review-card__more">Ver más</button>
                    </div>
                </article>
                <article class="review-card">
                    <img src="images/user2.jpg" alt="Alejandra Osorio" class="review-card__avatar">
                    <div class="review-card__body">
                        <span class="review-card__company">Mesa de Medios</span>
                        <h3 class="review-card__name">Alejandra Osorio</h3>
                        <p class="review-card__text">La empresa Wiquiweb ha llevado a cabo diversos proyectos de diseño
                            web, hosting y diseño gráfico para nuestra organización.</p>
                        <button class="review-card__more">Ver más</button>
                    </div>
                </article>
                <article class="review-card">
                    <img src="images/user3.jpg" alt="Edwin Ortega" class="review-card__avatar">
                    <div class="review-card__body">
                        <span class="review-card__company">A todo deporte</span>
                        <h3 class="review-card__name">Edwin Ortega</h3>
                        <p class="review-card__text">He recibido un considerable respaldo para llevar a cabo la
                            implementación tecnológica de mi página web y correo corporativo.</p>
                        <button class="review-card__more">Ver más</button>
                    </div>
                </article>
                <article class="review-card">
                    <img src="images/user4.jpg" alt="Vanessa Martinez" class="review-card__avatar">
                    <div class="review-card__body">
                        <span class="review-card__company">Web Designer</span>
                        <h3 class="review-card__name">Vanessa Martinez</h3>
                        <p class="review-card__text">Estoy profundamente agradecido con WiquiWeb. Su profesionalismo y
                            dedicación se reflejan en cada detalle del sitio.</p>
                        <button class="review-card__more">Ver más</button>
                    </div>
                </article>
            </div>
        </div>
    </section>

@endsection
