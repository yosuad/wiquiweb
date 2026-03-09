@extends('components.app')

@section('title', 'Inicio')

@section('content')

<!-- ════════════════ BANNER ═══════════════ -->
<section class="home-banner">

    <!-- Menú lateral integrado al bloque home-banner -->
    <nav class="home-banner__menu" aria-label="Redes sociales">
        <ul class="home-banner__menu-list">

            <!-- Línea superior -->
            <li class="home-banner__menu-divider"></li>

            <!-- Opciones de redes sociales -->
            <li class="home-banner__menu-item">
                <a href="https://facebook.com" target="_blank" class="home-banner__menu-link" aria-label="Facebook">
                    <i class="home-banner__menu-icon fa-brands fa-facebook-f" aria-hidden="true"></i>
                </a>
            </li>
            <li class="home-banner__menu-item">
                <a href="https://instagram.com" target="_blank" class="home-banner__menu-link" aria-label="Instagram">
                    <i class="home-banner__menu-icon fa-brands fa-instagram" aria-hidden="true"></i>
                </a>
            </li>
            <li class="home-banner__menu-item">
                <a href="https://tiktok.com" target="_blank" class="home-banner__menu-link" aria-label="TikTok">
                    <i class="home-banner__menu-icon fa-brands fa-tiktok" aria-hidden="true"></i>
                </a>
            </li>
            <li class="home-banner__menu-item">
                <a href="https://linkedin.com" target="_blank" class="home-banner__menu-link" aria-label="LinkedIn">
                    <i class="home-banner__menu-icon fa-brands fa-linkedin-in" aria-hidden="true"></i>
                </a>
            </li>
            <li class="home-banner__menu-item">
                <a href="https://youtube.com" target="_blank" class="home-banner__menu-link" aria-label="YouTube">
                    <i class="home-banner__menu-icon fa-brands fa-youtube" aria-hidden="true"></i>
                </a>
            </li>

            <!-- Línea inferior -->
            <li class="home-banner__menu-divider"></li>
        </ul>
    </nav>

    <!-- Contenido principal -->
    <div class="home-banner__content">
        <h1 class="home-banner__subtitle wow fadeInUp">Páginas web</h1>
        <h2 class="home-banner__title wow fadeInUp">
            Hosting <span class="home-banner__highlight">y Correos</span>
        </h2>
        <p class="home-banner__text wow fadeInDown">
            Diseño profesional para impulsar tu presencia digital desde el primer clic
        </p>

        <div class="home-banner__actions">
            <a href="#" class="home-banner__btn home-banner__btn--primary wow fadeInLeft">
                Quiero mi web
            </a>
            <a href="#" class="home-banner__btn home-banner__btn--secondary wow fadeInRight">
                Hablar con un asesor
            </a>
        </div>
    </div>

    <!-- Imagen principal -->
    <div class="home-banner__image">
        <img src="tu-imagen.jpg" alt="Imagen principal del banner">
    </div>

</section>



  <!-- ═══════════════ CLIENT LOGOS ═══════════════ -->
  <section class="clients">
    <div class="container">
      <p class="clients__label">Empresas que confían en nosotros</p>
      <div class="clients__track-wrapper">
        <div class="clients__track">
          <!-- Original + duplicated for infinite scroll -->
          <div class="clients__item"><span>PT</span></div>
          <div class="clients__item"><span>MM</span></div>
          <div class="clients__item"><span>AD</span></div>
          <div class="clients__item"><span>CL</span></div>
          <div class="clients__item"><span>TS</span></div>
          <div class="clients__item"><span>RG</span></div>
          <div class="clients__item"><span>SD</span></div>
          <div class="clients__item"><span>AM</span></div>
          <!-- Duplicated -->
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
    <div class="container">
      <div class="services__header">
        <p class="section-subtitle">¿Qué Podemos hacer por ti?</p>
        <h2 class="section-title">Servicios que te <span class="wiqui-gradient-text">Pueden ayudar</span></h2>
      </div>

      <div class="services__grid">
        <article class="card">
          <div class="card__icon"><i data-lucide="globe"></i></div>
          <h3 class="card__title">Diseño Web</h3>
          <p class="card__text">Creamos páginas web modernas, responsivas y optimizadas para buscadores. Diseños personalizados que reflejan la identidad de tu marca y conectan con tu audiencia.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>

        <article class="card">
          <div class="card__icon"><i data-lucide="palette"></i></div>
          <h3 class="card__title">Diseño Gráfico</h3>
          <p class="card__text">Diseño de identidad corporativa, logotipos, material publicitario y todo lo que necesitas para potenciar la imagen visual de tu empresa.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>

        <article class="card">
          <div class="card__icon"><i data-lucide="building-2"></i></div>
          <h3 class="card__title">Gestión Empresarial</h3>
          <p class="card__text">Administración completa de servicios de hosting, dominios y configuración de correos corporativos para mantener tu negocio siempre en línea.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>

        <article class="card">
          <div class="card__icon"><i data-lucide="mail"></i></div>
          <h3 class="card__title">Correos Corporativos</h3>
          <p class="card__text">Configuración profesional de correos empresariales con tu dominio. Seguridad, capacidad y soporte técnico incluido.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>

        <article class="card">
          <div class="card__icon"><i data-lucide="monitor-smartphone"></i></div>
          <h3 class="card__title">Actualizaciones Web</h3>
          <p class="card__text">Mantenimiento y actualización constante de tu sitio web. Contenido fresco, seguridad mejorada y rendimiento optimizado.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>

        <article class="card">
          <div class="card__icon"><i data-lucide="megaphone"></i></div>
          <h3 class="card__title">Marketing Digital</h3>
          <p class="card__text">Estrategias de marketing digital, gestión de redes sociales y campañas publicitarias para aumentar tu visibilidad online.</p>
          <a href="#" class="card__link">Leer más <i data-lucide="arrow-right" style="width:16px;height:16px;"></i></a>
        </article>
      </div>
    </div>
  </section>

  <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
  <section class="why-us">
    <div class="container">
      <div class="section-header">
        <p class="section-subtitle">Nuestra Diferencia</p>
        <h2 class="section-title">¿Por qué <span class="wiqui-gradient-text">Elegirnos?</span></h2>
        <p class="text-muted" style="color:var(--muted-foreground);font-size:1.125rem;margin-top:1rem;">
          Combinamos creatividad, tecnología y compromiso para llevar tu negocio al siguiente nivel digital.
        </p>
      </div>

      <div class="why-us__grid">
        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="zap"></i></div>
          <div>
            <h3 class="feature-card__title">Rápido y Eficiente</h3>
            <p class="feature-card__text">Entregamos proyectos en tiempo récord sin sacrificar calidad.</p>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="shield"></i></div>
          <div>
            <h3 class="feature-card__title">Seguridad Garantizada</h3>
            <p class="feature-card__text">Protegemos tu sitio con las mejores prácticas de seguridad web.</p>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="heart-handshake"></i></div>
          <div>
            <h3 class="feature-card__title">Soporte Personalizado</h3>
            <p class="feature-card__text">Atención directa y personalizada para resolver todas tus dudas.</p>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="clock"></i></div>
          <div>
            <h3 class="feature-card__title">Disponibilidad 24/7</h3>
            <p class="feature-card__text">Tu sitio siempre en línea con monitoreo constante.</p>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="award"></i></div>
          <div>
            <h3 class="feature-card__title">+10 Años de Experiencia</h3>
            <p class="feature-card__text">Conocimiento probado en diseño y desarrollo web.</p>
          </div>
        </div>

        <div class="feature-card">
          <div class="feature-card__icon"><i data-lucide="check-circle"></i></div>
          <div>
            <h3 class="feature-card__title">Resultados Comprobados</h3>
            <p class="feature-card__text">Más de 500 clientes satisfechos respaldan nuestro trabajo.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════════════ WORK PROCESS ═══════════════ -->
  <section class="process">
    <div class="container">
      <div class="section-header">
        <p class="section-subtitle">Cómo Trabajamos</p>
        <h2 class="section-title">Nuestro <span class="wiqui-gradient-text">Proceso</span></h2>
        <p style="color:var(--muted-foreground);font-size:1.125rem;margin-top:1rem;">
          Un proceso claro y transparente para convertir tus ideas en realidad.
        </p>
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
    <div class="container">
      <div class="section-header">
        <p class="section-subtitle text-primary-color">Nuestro Trabajo</p>
        <h2 class="section-title text-white">Proyectos <span class="wiqui-gradient-text">Destacados</span></h2>
        <p class="text-white-70" style="font-size:1.125rem;">Una muestra de nuestros mejores trabajos y casos de éxito.</p>
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
        <a href="#" class="btn-primary">Ver todos los proyectos</a>
      </div>
    </div>
  </section>

  <!-- ═══════════════ STATS ═══════════════ -->
  <section class="stats">
    <div class="container">
      <div class="section-header">
        <p class="section-subtitle text-primary-color">Agencia de Diseño y Desarrollo</p>
        <h2 class="section-title text-white">Estadísticas de trabajos <span class="wiqui-gradient-text">Realizados</span></h2>
        <p class="text-white-70" style="font-size:1.125rem;">
          Aquí puedes encontrar un resumen de nuestras estadísticas durante estos años de trabajo.
        </p>
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
    <div class="container">
      <div class="section-header">
        <p class="section-subtitle">Reseñas</p>
        <h2 class="section-title">Qué dicen nuestros <span class="wiqui-gradient-text">Clientes?</span></h2>
        <p style="color:var(--muted-foreground);font-size:1.125rem;">
          Nuestros clientes siempre salen satisfechos con sus webs y apps.
        </p>
      </div>

      <div class="reviews__grid">
        <article class="review-card">
          <img src="images/user1.jpg" alt="Jorge Mario Escobar" class="review-card__avatar">
          <div>
            <span class="review-card__company">Periódico el Taller</span>
            <h3 class="review-card__name">Jorge Mario Escobar</h3>
            <p class="review-card__text">Destacamos en la red gracias a su eficaz capacitación y asesoría constante, permitiéndonos gestionar la página de forma autónoma.</p>
            <button class="review-card__more">Ver más</button>
          </div>
        </article>

        <article class="review-card">
          <img src="images/user2.jpg" alt="Alejandra Osorio" class="review-card__avatar">
          <div>
            <span class="review-card__company">Mesa de Medios</span>
            <h3 class="review-card__name">Alejandra Osorio</h3>
            <p class="review-card__text">La empresa Wiquiweb ha llevado a cabo diversos proyectos de diseño web, hosting y diseño gráfico para nuestra organización.</p>
            <button class="review-card__more">Ver más</button>
          </div>
        </article>

        <article class="review-card">
          <img src="images/user3.jpg" alt="Edwin Ortega" class="review-card__avatar">
          <div>
            <span class="review-card__company">A todo deporte</span>
            <h3 class="review-card__name">Edwin Ortega</h3>
            <p class="review-card__text">He recibido un considerable respaldo para llevar a cabo la implementación tecnológica de mi página web y correo corporativo.</p>
            <button class="review-card__more">Ver más</button>
          </div>
        </article>

        <article class="review-card">
          <img src="images/user4.jpg" alt="Vanessa Martinez" class="review-card__avatar">
          <div>
            <span class="review-card__company">Web Designer</span>
            <h3 class="review-card__name">Vanessa Martinez</h3>
            <p class="review-card__text">Estoy profundamente agradecido con WiquiWeb. Su profesionalismo y dedicación se reflejan en cada detalle del sitio.</p>
            <button class="review-card__more">Ver más</button>
          </div>
        </article>
      </div>
    </div>
  </section>

@endsection
