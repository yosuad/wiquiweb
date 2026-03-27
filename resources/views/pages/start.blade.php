@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <!-- ════════════════ BANNER ═══════════════ -->
    <section class="start-banner">

        <nav class="start-banner__menu" aria-label="Redes sociales">
            <ul class="start-banner__menu-list">
                <li class="start-banner__menu-divider"></li>

                <li class="start-banner__menu-item">
                    <a href="https://www.facebook.com/wiquieb" target="_blank" class="start-banner__menu-link"
                        aria-label="Facebook">
                        <svg class="start-banner__menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                            fill="currentColor">
                            <path
                                d="M80 299.3l0 212.7 116 0 0-212.7 86.5 0 18-97.8-104.5 0 0-34.6c0-51.7 20.3-71.5 72.7-71.5 16.3 0 29.4 .4 37 1.2l0-88.7C291.4 4 256.4 0 236.2 0 129.3 0 80 50.5 80 159.4l0 42.1-66 0 0 97.8 66 0z" />
                        </svg>
                    </a>
                </li>

                <li class="start-banner__menu-item">
                    <a href="https://www.instagram.com/wiquiweb" target="_blank" class="start-banner__menu-link"
                        aria-label="Instagram">
                        <svg class="start-banner__menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            fill="currentColor">
                            <path
                                d="M224.3 141a115 115 0 1 0 -.6 230 115 115 0 1 0 .6-230zm-.6 40.4a74.6 74.6 0 1 1 .6 149.2 74.6 74.6 0 1 1 -.6-149.2zm93.4-45.1a26.8 26.8 0 1 1 53.6 0 26.8 26.8 0 1 1 -53.6 0zm129.7 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM399 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                        </svg>
                    </a>
                </li>

                <li class="start-banner__menu-item">
                    <a href="https://www.tiktok.com/@wiquiweb" target="_blank" class="start-banner__menu-link"
                        aria-label="TikTok">
                        <svg class="start-banner__menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            fill="currentColor">
                            <path
                                d="M448.5 209.9c-44 .1-87-13.6-122.8-39.2l0 178.7c0 33.1-10.1 65.4-29 92.6s-45.6 48-76.6 59.6-64.8 13.5-96.9 5.3-60.9-25.9-82.7-50.8-35.3-56-39-88.9 2.9-66.1 18.6-95.2 40-52.7 69.6-67.7 62.9-20.5 95.7-16l0 89.9c-15-4.7-31.1-4.6-46 .4s-27.9 14.6-37 27.3-14 28.1-13.9 43.9 5.2 31 14.5 43.7 22.4 22.1 37.4 26.9 31.1 4.8 46-.1 28-14.4 37.2-27.1 14.2-28.1 14.2-43.8l0-349.4 88 0c-.1 7.4 .6 14.9 1.9 22.2 3.1 16.3 9.4 31.9 18.7 45.7s21.3 25.6 35.2 34.6c19.9 13.1 43.2 20.1 67 20.1l0 87.4z" />
                        </svg>
                    </a>
                </li>

                <li class="start-banner__menu-item">
                    <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="start-banner__menu-link"
                        aria-label="LinkedIn">
                        <svg class="start-banner__menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                            fill="currentColor">
                            <path
                                d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z" />
                        </svg>
                    </a>
                </li>

                <li class="start-banner__menu-item">
                    <a href="https://www.youtube.com/@wiquiweb" target="_blank" class="start-banner__menu-link"
                        aria-label="YouTube">
                        <svg class="start-banner__menu-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"
                            fill="currentColor">
                            <path
                                d="M549.7 124.1C543.5 100.4 524.9 81.8 501.4 75.5 458.9 64 288.1 64 288.1 64S117.3 64 74.7 75.5C51.2 81.8 32.7 100.4 26.4 124.1 15 167 15 256.4 15 256.4s0 89.4 11.4 132.3c6.3 23.6 24.8 41.5 48.3 47.8 42.6 11.5 213.4 11.5 213.4 11.5s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zM232.2 337.6l0-162.4 142.7 81.2-142.7 81.2z" />
                        </svg>
                    </a>
                </li>

                <li class="start-banner__menu-divider"></li>
            </ul>
        </nav>

        <div class="start-banner__content">
            <h1 class="start-banner__subtitle wow fadeInUp">Páginas web</h1>
            <h2 class="start-banner__title wow fadeInUp">
                Hosting <span class="start-banner__highlight">y Correos</span>
            </h2>
            <p class="start-banner__text wow fadeInDown">
                Diseño profesional para impulsar tu presencia digital
                <br>
                desde el primer clic
            </p>
            <div class="start-banner__actions">
                <a href="{{ route('services.web-design') }}"
                    class="start-banner__btn start-banner__btn--primary wow fadeInLeft">Quiero mi web</a>
                <a href="{{ route('contact') }}" class="start-banner__btn start-banner__btn--secondary wow fadeInRight">Hablar con un
                    asesor</a>
            </div>
        </div>

        <div class="start-banner__video-wrapper">
            <video class="start-banner__video" autoplay muted loop playsinline>
                <source src="{{ asset('videos/banner-video.mp4') }}" type="video/mp4">
            </video>
        </div>

    </section>

    <!-- ═══════════════ CLIENT LOGOS ═══════════════ -->
    <section class="start-clients">
        <div class="start-clients__container">
            <p class="start-clients__label">Empresas que confían en nosotros</p>
            <div class="start-clients__track-wrapper">
                <div class="start-clients__track">
                    {{-- Grupo 1 --}}
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/enlacetropical.webp') }}" alt="Enlace Tropical">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/imperativocultural.webp') }}" alt="Imperativo Cultural">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/tulibroencasa.webp') }}" alt="Tu Libro en Casa">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/riostechnology.webp') }}" alt="Rios Technology">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/mesademedios.webp') }}" alt="Mesa de Medios">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/radiovisual.webp') }}" alt="Radio Visual">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/canalzona6tv.webp') }}" alt="Canal Zona 6">
                    </div>

                    {{-- Grupo 2 — duplicado para loop infinito sin salto --}}
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/enlacetropical.webp') }}" alt="Enlace Tropical">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/imperativocultural.webp') }}" alt="Imperativo Cultural">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/tulibroencasa.webp') }}" alt="Tu Libro en Casa">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/riostechnology.webp') }}" alt="Rios Technology">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/mesademedios.webp') }}" alt="Mesa de Medios">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/radiovisual.webp') }}" alt="Radio Visual">
                    </div>
                    <div class="start-clients__item">
                        <img src="{{ asset('img/clients/canalzona6tv.webp') }}" alt="Canal Zona 6">
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- ═══════════════ SERVICES ═══════════════ -->
    <section id="servicios" class="start-services">
        <div class="start-services__container">
            <div class="start-services__header">
                <p class="start-services__subtitle">¿Qué Podemos hacer por ti?</p>
                <h2 class="start-services__title">Servicios que te <span class="start-services__title-highlight">Pueden
                        ayudar</span></h2>
            </div>
            <div class="start-services__grid">

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="globe"></i></div>
                        <h3 class="start-card__title">Diseño Web</h3>
                    </div>
                    <p class="start-card__text">Creamos páginas web modernas, que se adaptan a cualquier dispositivo y
                        optimizadas para buscadores. Diseños personalizados que reflejan la identidad de tu marca y conectan
                        con tu audiencia.</p>
                    <a href="{{ route('services.web-design') }}" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="palette"></i></div>
                        <h3 class="start-card__title">Diseño Gráfico</h3>
                    </div>
                    <p class="start-card__text">Creamos el logo, los colores, las tarjetas y todo lo visual que hace que tu
                        negocio se vea profesional y coherente en cualquier lugar. Porque la primera impresión siempre entra
                        por los ojos.</p>
                    <a href="#" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="building-2"></i></div>
                        <h3 class="start-card__title">Gestión Empresarial</h3>
                    </div>
                    <p class="start-card__text">Nos encargamos de todo lo técnico: hosting, dominios y configuraciones para
                        que tu negocio esté siempre en línea y funcionando sin interrupciones.</p>
                    <a href="#" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="mail"></i></div>
                        <h3 class="start-card__title">Correos Corporativos</h3>
                    </div>
                    <p class="start-card__text">Creamos y configuramos correos empresariales con tu propio dominio,
                        ayudándote a proyectar una imagen más profesional y confiable, y a mantenerte siempre comunicado sin
                        problemas.</p>
                    <a href="#" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="monitor-smartphone"></i></div>
                        <h3 class="start-card__title">Actualizaciones Web</h3>
                    </div>
                    <p class="start-card__text">Mantenemos tu sitio web actualizado, seguro y optimizado, para que siempre
                        funcione correctamente y tu contenido esté al día.</p>
                    <a href="#" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

                <article class="start-card">
                    <div class="start-card__header">
                        <div class="start-card__icon"><i data-lucide="megaphone"></i></div>
                        <h3 class="start-card__title">Marketing Digital</h3>
                    </div>
                    <p class="start-card__text">Impulsamos tu presencia online con estrategias, redes sociales y campañas
                        publicitarias que atraen más clientes a tu negocio.</p>
                    <a href="#" class="start-card__link">
                        Leer más
                        <i class="start-card__link-icon" data-lucide="arrow-right"></i>
                    </a>
                </article>

            </div>
        </div>
    </section>

    <!-- ═══════════════ WHY CHOOSE US ═══════════════ -->
    <section class="start-why-us">
        <div class="start-why-us__container">
            <div class="start-why-us__header">
                <p class="start-why-us__subtitle">Nuestra Diferencia</p>
                <h2 class="start-why-us__title">¿Por qué <span class="start-why-us__title-highlight">Elegirnos?</span>
                </h2>
                <p class="start-why-us__description">Combinamos creatividad, tecnología y compromiso para llevar tu negocio
                    al siguiente nivel digital.</p>
            </div>
            <div class="start-why-us__grid">
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="zap"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">Rápido y Eficiente</h3>
                        <p class="start-feature-card__text">Entregamos proyectos en tiempo récord sin sacrificar calidad.
                        </p>
                    </div>
                </div>
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="shield"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">Seguridad Garantizada</h3>
                        <p class="start-feature-card__text">Protegemos tu sitio con las mejores prácticas de seguridad web.
                        </p>
                    </div>
                </div>
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="heart-handshake"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">Soporte Personalizado</h3>
                        <p class="start-feature-card__text">Atención directa y personalizada para resolver todas tus dudas.
                        </p>
                    </div>
                </div>
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="clock"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">Disponibilidad 24/7</h3>
                        <p class="start-feature-card__text">Tu sitio siempre en línea con monitoreo constante.</p>
                    </div>
                </div>
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="award"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">+10 Años de Experiencia</h3>
                        <p class="start-feature-card__text">Conocimiento probado en diseño y desarrollo web.</p>
                    </div>
                </div>
                <div class="start-feature-card">
                    <div class="start-feature-card__icon"><i data-lucide="check-circle"></i></div>
                    <div class="start-feature-card__body">
                        <h3 class="start-feature-card__title">Resultados Comprobados</h3>
                        <p class="start-feature-card__text">Más de 500 clientes satisfechos respaldan nuestro trabajo.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ WORK PROCESS ═══════════════ -->
    <section class="start-process">
        <div class="start-process__container">
            <div class="start-process__header">
                <p class="start-process__subtitle">Cómo Trabajamos</p>
                <h2 class="start-process__title">Nuestro <span class="start-process__title-highlight">Proceso</span></h2>
                <p class="start-process__description">Un proceso claro y transparente para convertir tus ideas en realidad.
                </p>
            </div>
            <div class="start-process__grid">
                <div class="start-process__line"></div>
                <div class="start-step">
                    <div class="start-step__number-bg">01</div>
                    <div class="start-step__icon">
                        <i data-lucide="message-square"></i>
                        <span class="start-step__badge">01</span>
                    </div>
                    <h3 class="start-step__title">Consulta</h3>
                    <p class="start-step__text">Escuchamos tus ideas, objetivos y necesidades para entender tu visión.</p>
                </div>
                <div class="start-step">
                    <div class="start-step__number-bg">02</div>
                    <div class="start-step__icon">
                        <i data-lucide="pen-tool"></i>
                        <span class="start-step__badge">02</span>
                    </div>
                    <h3 class="start-step__title">Diseño</h3>
                    <p class="start-step__text">Creamos mockups y prototipos que reflejan la identidad de tu marca.</p>
                </div>
                <div class="start-step">
                    <div class="start-step__number-bg">03</div>
                    <div class="start-step__icon">
                        <i data-lucide="code"></i>
                        <span class="start-step__badge">03</span>
                    </div>
                    <h3 class="start-step__title">Desarrollo</h3>
                    <p class="start-step__text">Convertimos el diseño en código limpio, optimizado y funcional.</p>
                </div>
                <div class="start-step">
                    <div class="start-step__number-bg">04</div>
                    <div class="start-step__icon">
                        <i data-lucide="rocket"></i>
                        <span class="start-step__badge">04</span>
                    </div>
                    <h3 class="start-step__title">Lanzamiento</h3>
                    <p class="start-step__text">Publicamos tu sitio y te brindamos soporte continuo.</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ═══════════════ CONTACT ═══════════════ -->
    <section id="contacto" class="start-contact">
        <div class="start-contact__container">

            <!-- ===== Lado izquierdo — Info ===== -->
            <div class="start-contact__info">
                <p class="start-contact__subtitle">¿Listo para empezar?</p>
                <h2 class="start-contact__title">Hablemos de tu <span
                        class="start-contact__title-highlight">proyecto</span></h2>
                <p class="start-contact__description">Cuéntanos qué necesitas y te contactamos en menos de 24 horas.</p>

                <ul class="start-contact__benefits">
                    <li class="start-contact__benefit">
                        <div class="start-contact__benefit-icon"><i data-lucide="clock"></i></div>
                        <div class="start-contact__benefit-body">
                            <h3 class="start-contact__benefit-title">Respuesta en menos de 24h</h3>
                            <p class="start-contact__benefit-text">Te contactamos el mismo día hábil para conocer mejor tu
                                proyecto.</p>
                        </div>
                    </li>
                    <li class="start-contact__benefit">
                        <div class="start-contact__benefit-icon"><i data-lucide="shield-check"></i></div>
                        <div class="start-contact__benefit-body">
                            <h3 class="start-contact__benefit-title">Primera consulta sin costo</h3>
                            <p class="start-contact__benefit-text">Conversamos sobre tu idea sin ningún compromiso de
                                contratación.</p>
                        </div>
                    </li>
                    <li class="start-contact__benefit">
                        <div class="start-contact__benefit-icon"><i data-lucide="users"></i></div>
                        <div class="start-contact__benefit-body">
                            <h3 class="start-contact__benefit-title">+500 proyectos completados</h3>
                            <p class="start-contact__benefit-text">Más de 10 años de experiencia en diseño y desarrollo
                                web.</p>
                        </div>
                    </li>
                    <li class="start-contact__benefit">
                        <div class="start-contact__benefit-icon"><i data-lucide="headphones"></i></div>
                        <div class="start-contact__benefit-body">
                            <h3 class="start-contact__benefit-title">Soporte post-entrega</h3>
                            <p class="start-contact__benefit-text">Planes de mantenimiento y soporte disponibles para
                                mantener tu sitio siempre activo.</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- ===== Lado derecho — Formulario ===== -->
            <div class="start-contact__form-wrapper">

                @if (session('success'))
                    <div class="start-contact__success">
                        <i data-lucide="circle-check"></i>
                        <h3>¡Mensaje enviado!</h3>
                        <p>{{ session('success') }}</p>
                    </div>
                @else
                    <form class="start-contact__form" method="POST" action="{{ route('leads.store') }}">
                        @csrf

                        <input type="hidden" name="origin" value="web">

                        <div class="start-contact__form-header">
                            <h3 class="start-contact__form-title">Cuéntanos sobre tu proyecto</h3>
                            <p class="start-contact__form-subtitle">Completa el formulario y te contactamos</p>
                        </div>

                        <div class="start-contact__form-row">
                            <div class="start-contact__form-group">
                                <label for="contact_first_name" class="start-contact__form-label">Nombre</label>
                                <input type="text" id="contact_first_name" name="first_name"
                                    class="start-contact__form-input" placeholder="Tu nombre" maxlength="50" required>
                            </div>
                            <div class="start-contact__form-group">
                                <label for="contact_last_name" class="start-contact__form-label">Apellido</label>
                                <input type="text" id="contact_last_name" name="last_name"
                                    class="start-contact__form-input" placeholder="Tu apellido" maxlength="50" required>
                            </div>
                        </div>

                        <div class="start-contact__form-group">
                            <label for="contact_whatsapp" class="start-contact__form-label">WhatsApp</label>
                            <input type="tel" id="contact_whatsapp" name="whatsapp"
                                class="start-contact__form-input" placeholder="+57 320 413 25 00" maxlength="20"
                                required>
                        </div>

                        <div class="start-contact__form-group">
                            <label for="contact_email" class="start-contact__form-label">Correo electrónico</label>
                            <input type="email" id="contact_email" name="email" class="start-contact__form-input"
                                placeholder="tu@correo.com" maxlength="100">
                        </div>

                        <div class="start-contact__form-group">
                            <label for="contact_service" class="start-contact__form-label">¿Qué necesitas?</label>
                            <select id="contact_service" name="service_interest" class="start-contact__form-input">
                                <option value="pagina_web">Página web</option>
                                <option value="correos">Correos corporativos</option>
                                <option value="diseno_grafico">Diseño gráfico</option>
                                <option value="marketing">Marketing digital</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        {{-- Política de privacidad --}}
                        <div class="start-contact__form-privacy">
                            <input type="checkbox" id="privacy" name="privacy" required>
                            <label for="privacy">
                                He leído y acepto la
                                <a href="{{ route('privacy') }}" target="_blank">Política de Privacidad</a>
                            </label>
                        </div>

                        <button type="submit" class="start-contact__form-btn">
                            <i data-lucide="send"></i>
                            Enviar mensaje
                        </button>

                    </form>
                @endif

            </div>

        </div>
    </section>

    <!-- ═══════════════ PORTFOLIO ═══════════════ -->
    <section id="portafolio" class="start-portfolio">
        <div class="start-portfolio__container">
            <div class="start-portfolio__header">
                <p class="start-portfolio__subtitle">Nuestro Trabajo</p>
                <h2 class="start-portfolio__title">Proyectos <span
                        class="start-portfolio__title-highlight">Destacados</span></h2>
                <p class="start-portfolio__description">Una muestra de nuestros mejores trabajos y casos de éxito.</p>
            </div>
            <div class="start-portfolio__grid">

                <a href="https://tulibroencasa.com" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/tulibroencasa.webp') }}" alt="Tu Libro en Casa"
                        class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Diseño & E-commerce</span>
                        <h3 class="start-project__title">Tu Libro en Casa</h3>
                    </div>
                </a>

                <a href="https://enlacetropical.com" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/enlacetropical.webp') }}" alt="Enlace Tropical"
                        class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Identidad & Diseño Web</span>
                        <h3 class="start-project__title">Enlace Tropical</h3>
                    </div>
                </a>

                <a href="https://wiquiweb.co/persianasycortinasvalencia" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/persianasycortinasvalencia.webp') }}"
                        alt="Persianas y Cortinas Valencia" class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Landing Page</span>
                        <h3 class="start-project__title">Persianas y Cortinas Valencia</h3>
                    </div>
                </a>

                <a href="https://wiquiweb.co/canalzona6tv" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/canalzona6tv.webp') }}" alt="Canal Zona 6 TV"
                        class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Landing Page</span>
                        <h3 class="start-project__title">Canal Zona 6 TV</h3>
                    </div>
                </a>

                <a href="https://www.emisoraradiovisual.com" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/radiovisual.webp') }}" alt="Emisora Radio Visual"
                        class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Streaming</span>
                        <h3 class="start-project__title">Emisora Radio Visual</h3>
                    </div>
                </a>

                <a href="https://las10noticiasmasbuscadas.com" target="_blank" class="start-project">
                    <img src="{{ asset('img/portafolio/las10noticiasmasbuscadas.webp') }}"
                        alt="Las 10 Noticias Más Buscadas" class="start-project__image">
                    <div class="start-project__overlay"></div>
                    <div class="start-project__content">
                        <span class="start-project__category">Diseño Web</span>
                        <h3 class="start-project__title">Las 10 Noticias Más Buscadas</h3>
                    </div>
                </a>

            </div>
            <div class="start-portfolio__cta">
                <a href="#" class="start-portfolio__btn">Ver todos los proyectos</a>
            </div>
        </div>
    </section>

    <!-- ═══════════════ STATS ═══════════════ -->
    <section class="start-stats">
        <div class="start-stats__container">
            <div class="start-stats__header">
                <p class="start-stats__subtitle">Agencia de Diseño y Desarrollo</p>
                <h2 class="start-stats__title">Estadísticas de trabajos <span
                        class="start-stats__title-highlight">Realizados</span></h2>
                <p class="start-stats__description">Aquí puedes encontrar un resumen de nuestras estadísticas durante estos
                    años de trabajo.</p>
            </div>
            <div class="start-stats__grid">
                <div class="start-stat">
                    <div class="start-stat__icon"><i data-lucide="calendar"></i></div>
                    <span class="start-stat__count">+{{ $anos }}</span>
                    <h3 class="start-stat__label">Período de Actividad</h3>
                </div>
                <div class="start-stat">
                    <div class="start-stat__icon"><i data-lucide="briefcase"></i></div>
                    <span class="start-stat__count">+{{ $proyectos }}</span>
                    <h3 class="start-stat__label">Proyectos realizados</h3>
                </div>
                <div class="start-stat">
                    <div class="start-stat__icon"><i data-lucide="users"></i></div>
                    <span class="start-stat__count">+{{ $colaborativos }}</span>
                    <h3 class="start-stat__label">Trabajo colaborativo</h3>
                </div>
                <div class="start-stat">
                    <div class="start-stat__icon"><i data-lucide="heart"></i></div>
                    <span class="start-stat__count">+{{ $clientes }}</span>
                    <h3 class="start-stat__label">Clientes satisfechos</h3>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════════════ REVIEWS ═══════════════ -->
    <section id="testimonios" class="start-reviews">
    <div class="start-reviews__container">
        <div class="start-reviews__header">
            <p class="start-reviews__subtitle">Reseñas</p>
            <h2 class="start-reviews__title">Qué dicen nuestros <span
                    class="start-reviews__title-highlight">Clientes</span></h2>           
        </div>
        <div class="start-reviews__grid">

            <article class="start-review-card">
                <div class="start-review-card__avatar-wrapper">
                    <img src="{{ asset('img/reviews/Jorge_Mario.webp') }}" alt="Jorge Mario Escobar" class="start-review-card__avatar">
                </div>
                <div class="start-review-card__body">
                    <h3 class="start-review-card__company">Periódico el Taller</h3>
                    <span class="start-review-card__name">Jorge Mario Escobar</span>
                    <p class="start-review-card__text">Destacamos en la red gracias a su eficaz capacitación y asesoría
                        constante, permitiéndonos gestionar la página de forma autónoma.</p>
                    <button class="start-review-card__more">Ver más</button>
                </div>
            </article>

            <article class="start-review-card">
                <div class="start-review-card__avatar-wrapper">
                    <img src="{{ asset('img/reviews/Alejandra_Osorio.webp') }}" alt="Alejandra Osorio" class="start-review-card__avatar">
                </div>
                <div class="start-review-card__body">
                    <h3 class="start-review-card__company">Mesa de Medios</h3>
                    <span class="start-review-card__name">Alejandra Osorio</span>
                    <p class="start-review-card__text">La empresa Wiquiweb ha llevado a cabo diversos proyectos de
                        diseño web, hosting y diseño gráfico para nuestra organización.</p>
                    <button class="start-review-card__more">Ver más</button>
                </div>
            </article>

            <article class="start-review-card">
                <div class="start-review-card__avatar-wrapper">
                    <img src="{{ asset('img/reviews/Edwin_Ortega.webp') }}" alt="Edwin Ortega" class="start-review-card__avatar">
                </div>
                <div class="start-review-card__body">
                    <h3 class="start-review-card__company">A todo deporte</h3>
                    <span class="start-review-card__name">Edwin Ortega</span>
                    <p class="start-review-card__text">He recibido un considerable respaldo para llevar a cabo la
                        implementación tecnológica de mi página web y correo corporativo.</p>
                    <button class="start-review-card__more">Ver más</button>
                </div>
            </article>

            <article class="start-review-card">
                <div class="start-review-card__avatar-wrapper">
                    <img src="{{ asset('img/reviews/Vanessa_Martinez.webp') }}" alt="Vanessa Martinez" class="start-review-card__avatar">
                </div>
                <div class="start-review-card__body">
                    <h3 class="start-review-card__company">Web Designer</h3>
                    <span class="start-review-card__name">Vanessa Martinez</span>
                    <p class="start-review-card__text">Estoy profundamente agradecida con WiquiWeb. Su profesionalismo
                        y dedicación se reflejan en cada detalle del sitio.</p>
                    <button class="start-review-card__more">Ver más</button>
                </div>
            </article>

        </div>
    </div>
</section>
    
{{-- ═══════════════ WHATSAPP BUTTON ═══════════════ --}}
<a href="https://api.whatsapp.com/send?phone=+573205864135&text=Me%20interesan%20sus%20servicios%20y%20me%20gustar%C3%ADa%20obtener%20m%C3%A1s%20informaci%C3%B3n."
    target="_blank"
    rel="noopener noreferrer"
    class="whatsapp-btn"
    aria-label="Contactar por WhatsApp">
    <svg class="whatsapp-btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
    </svg>
</a>


@endsection
