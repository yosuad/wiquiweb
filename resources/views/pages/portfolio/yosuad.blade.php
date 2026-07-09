<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Yosuad — rapero, poeta y maestro de ceremonia. Disco 'Home Run' ya disponible. Bio, discografía, trayectoria y contacto.">
    <meta property="og:title" content="YOSUAD — Home Run">
    <meta property="og:description" content="Rapero, poeta y maestro de ceremonia. Disco 'Home Run' ya disponible.">
    <meta property="og:type" content="website">
    <title>YOSUAD — Home Run · Hip Hop desde Medellín</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Dancing+Script:wght@700&family=Space+Grotesk:wght@400;500;700&display=swap"
        rel="stylesheet">

    @vite(['resources/css/pages/portfolio/yosuad.css'])
</head>

<body class="yosuad">

    {{-- ════════════════ NAV ════════════════ --}}
    <header class="ys-nav">
        <div class="ys-nav__container">
            <a href="#top" class="ys-nav__brand" aria-label="Yosuad — inicio">
                <img src="{{ asset('img/portfolio/yosuad/logo.png') }}" alt="Yosuad" class="ys-nav__logo">
            </a>

            <button class="ys-nav__toggle" type="button" aria-label="Abrir menú" aria-expanded="false"
                onclick="const n=this.closest('.ys-nav');const o=n.classList.toggle('is-open');this.setAttribute('aria-expanded',o);">
                <span></span><span></span><span></span>
            </button>

            <nav class="ys-nav__links" aria-label="Principal">
                <a href="#bio" class="ys-nav__link">Biografía</a>
                <a href="#vision" class="ys-nav__link">Visión</a>
                <a href="#disco" class="ys-nav__link">Discografía</a>
                <a href="#trayectoria" class="ys-nav__link">Trayectoria</a>
                <a href="#contacto" class="ys-nav__link">Contacto</a>
            </nav>

            <a href="#disco" class="ys-nav__cta">▶ ESCUCHAR</a>
        </div>
    </header>

    {{-- ════════════════ HERO ════════════════ --}}
    <section id="top" class="ys-hero"
        style="--ys-hero-desktop: url('{{ asset('img/portfolio/yosuad/Banner.webp') }}');
               --ys-hero-mobile:  url('{{ asset('img/portfolio/yosuad/Banner-mobile.webp') }}');">
        <div class="ys-hero__overlay" aria-hidden="true"></div>

        <div class="ys-hero__content">

            <div class="ys-hero__actions">
                <a href="#disco" class="ys-btn ys-btn--primary">▶ ESCUCHAR DISCO</a>
                <a href="#bio" class="ys-btn ys-btn--outline">CONOCER +</a>
            </div>
        </div>
    </section>

    {{-- ════════════════ MARQUEE ════════════════ --}}
    <div class="ys-marquee__track">
        @for ($i = 0; $i < 2; $i++)
            <span>HIP HOP</span>
            <img src="{{ asset('img/portfolio/yosuad/marquee-icon.png') }}" alt="" class="ys-marquee__icon">
            <span>MEDELLÍN</span>
            <img src="{{ asset('img/portfolio/yosuad/marquee-icon-1.png') }}" alt="" class="ys-marquee__icon">
            <span>HIP HOP</span>
            <img src="{{ asset('img/portfolio/yosuad/marquee-icon-2.png') }}" alt="" class="ys-marquee__icon">
            <span>Música</span>
            <img src="{{ asset('img/portfolio/yosuad/marquee-icon-3.png') }}" alt="" class="ys-marquee__icon">
            <span>HIP HOP</span>
            <img src="{{ asset('img/portfolio/yosuad/marquee-icon-4.png') }}" alt="" class="ys-marquee__icon">
        @endfor
    </div>

    {{-- ════════════════ BIOGRAFÍA ════════════════ --}}
    <section id="bio" class="ys-bio">
        <div class="ys-bio__container">
            <div class="ys-bio__label">
                <div class="ys-bio__label-box">
                    <h2 class="ys-bio__title">BIO<br>GRAFÍA</h2>
                </div>
                <img src="{{ asset('img/portfolio/yosuad/bats-emblem.png') }}" alt="" class="ys-bio__emblem"
                    aria-hidden="true">
            </div>
            <div class="ys-bio__text">
                <p>
                    A principios del 2005, <strong>Yosuad</strong> conoció a New Man, GMG,
                    El Poeta y otros 5 personajes que compartían con él su gusto musical. Juntos
                    deciden lanzarse como grupo, conocido como <strong>«Reparación H.D.T.»</strong>,
                    hijos de tuerca o buenrapes, se presentaron en todas las reuniones públicas o
                    familiares donde tenían espacio.
                </p>
                <p>
                    En 2009, acompañado de 2 amigos que habían hecho parte de la primera
                    agrupación —Nemesis y El Poeta— produjeron la primera canción profesional
                    en el sello Kaneli Records, elegida por el productor Archivo & Individual.
                </p>
                <p>
                    A finales del 2005, GMG, Newman y <strong>Yosuad</strong> conocieron a Andrés Muñoz,
                    músico manizaleño que estaba empezando a producir. Deciden trabajar su
                    producción musical, y en 2009 sacan su primer sencillo titulado
                    <em>«Nuestro Sentir»</em>. Al año siguiente el grupo y Yosuad comienzan su
                    recorrido como solistas.
                </p>
                <blockquote class="ys-bio__quote">
                    "Yosuad disfruta cada paso que logra a través de la música,
                    en la vida se muere de contradicciones."
                </blockquote>
            </div>
        </div>
    </section>

    {{-- ════════════════ VISIÓN & MISIÓN ════════════════ --}}
    <section id="vision" class="ys-vm">
        <span class="ys-vm__bolt" aria-hidden="true">⚡</span>
        <div class="ys-vm__container">
            <div class="ys-vm__col">
                <h2 class="ys-vm__heading">VISIÓN</h2>
                <div class="ys-vm__line"></div>
                <p class="ys-vm__text">
                    El principal enfoque de <strong>Yosuad</strong> es llegar a gran parte del mundo,
                    transmitiendo un espectro de gustos musicales y culturas que se sientan
                    identificados con las diferentes situaciones que expresa cada canción.
                </p>
            </div>
            <div class="ys-vm__col ys-vm__col--offset">
                <h2 class="ys-vm__heading">MISIÓN</h2>
                <div class="ys-vm__line"></div>
                <p class="ys-vm__text">
                    Yosuad se ha caracterizado por la dedicación a su proyecto, cuenta con un
                    equipo de trabajo interdisciplinar dispuesto a cumplir con cada expectativa
                    trazada dentro del proceso creativo y de lanzamiento.
                </p>
                <p class="ys-vm__slogan">
                    MI MÚSICA<br>
                    <span class="ys-vm__slogan-red">NO TIENE STOP</span><br>
                    NI PRECIO.
                </p>
            </div>
        </div>
    </section>

    {{-- ════════════════ DISCOGRAFÍA ════════════════ --}}
    <section id="disco" class="ys-disco">
        <div class="ys-disco__container">
            <div class="ys-disco__header">
                <div>
                    <p class="ys-disco__label">★ FEATURINGS ★</p>
                    <h2 class="ys-disco__title">DISCO<span class="ys-disco__title-accent">GRAFÍA</span></h2>
                </div>
                <p class="ys-disco__desc">
                    En manos del Grupo Sindikto ANT con Maestros de Ceremonia. La mezcla
                    perfecta. Actualmente Yosuad está trabajando como solista en su disco
                    titulado <strong>"Jotrón"</strong>.
                </p>
            </div>

            <div class="ys-disco__grid">
                <article class="ys-album ys-album--featured">
                    <div class="ys-album__top">
                        <span class="ys-album__year">2013</span>
                        <span class="ys-album__icon" aria-hidden="true">♫</span>
                    </div>
                    <h3 class="ys-album__name">JOTRÓN</h3>
                    <p class="ys-album__type">LP · Disco actual</p>
                    <a href="#" class="ys-album__play">▶ REPRODUCIR</a>
                </article>

                <article class="ys-album">
                    <div class="ys-album__top">
                        <span class="ys-album__year">2011</span>
                        <span class="ys-album__icon" aria-hidden="true">♫</span>
                    </div>
                    <h3 class="ys-album__name">MI MÚSICA NO TIENE STOP</h3>
                    <p class="ys-album__type">EP</p>
                    <a href="#" class="ys-album__play">▶ REPRODUCIR</a>
                </article>

                <article class="ys-album">
                    <div class="ys-album__top">
                        <span class="ys-album__year">2009</span>
                        <span class="ys-album__icon" aria-hidden="true">♫</span>
                    </div>
                    <h3 class="ys-album__name">NUESTRO SENTIR</h3>
                    <p class="ys-album__type">Sencillo · Reparación H.D.T.</p>
                    <a href="#" class="ys-album__play">▶ REPRODUCIR</a>
                </article>
            </div>
        </div>
    </section>

    {{-- ════════════════ TRAYECTORIA ════════════════ --}}
    <section id="trayectoria" class="ys-tray">
        <div class="ys-tray__container">
            <div class="ys-tray__left">
                <h2 class="ys-tray__title">TRAYEC<br><span class="ys-tray__title-red">TORIA</span></h2>
                <div class="ys-tray__line"></div>
                <p class="ys-tray__desc">
                    Con Maestros de Ceremonia hizo parte de diferentes escenarios,
                    algunos de ellos:
                </p>
                <img src="{{ asset('img/portfolio/yosuad/bats-emblem.png') }}" alt="" class="ys-tray__emblem"
                    aria-hidden="true">
            </div>
            <ul class="ys-tray__list">
                @foreach ([['Sede Comfama', 'La Ceja (Junto a Libarintro, Natra y M.I.Z.S)'], ['La Pelilla', 'Medellín 2007 y 2008 (Junto a Mr Moore, Yes, Acordes, Xafra)'], ['Festival de la Música', 'Ibagué 2006 (Junto a Diciembre Social, Nukyz, The Cronik Robles)'], ['Fiesta de la Música', 'Pasto 2007'], ['Familias de Vecinos', '2008 (Invitado por Sindikto Ant)'], ['Noche de Talentos', 'Domingo 21 de octubre 2013 · Aeropuerto Olaya Herrera'], ['Radio Movimiento Real', 'Programa de rap · Canal (zona 6 fm) desde 2013']] as $i => $item)
                    <li class="ys-tray__item">
                        <span class="ys-tray__num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <div class="ys-tray__info">
                            <p class="ys-tray__place">{{ $item[0] }}</p>
                            <p class="ys-tray__detail">{{ $item[1] }}</p>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- ════════════════ CONTACTO ════════════════ --}}
    <section id="contacto" class="ys-contact">
        <span class="ys-contact__bolt ys-contact__bolt--top" aria-hidden="true">⚡</span>
        <span class="ys-contact__bolt ys-contact__bolt--bottom" aria-hidden="true">⚡</span>
        <div class="ys-contact__container">
            <p class="ys-contact__label">★ CONTACTO ★</p>
            <h2 class="ys-contact__title">
                BOOKING &<br>
                <span class="ys-contact__script">colaboraciones</span>
            </h2>
            <p class="ys-contact__desc">
                Como solista ha estado en eventos como… y sigue construyendo el próximo
                Home Run. Escríbenos para shows, features y prensa.
            </p>
            <div class="ys-contact__actions">
                <a href="mailto:yosuadoficial@gmail.com" class="ys-btn ys-btn--dark">
                    ✉ YOSUADOFICIAL@GMAIL.COM
                </a>
            </div>
            <p class="ys-contact__location">📍 MEDELLÍN · COLOMBIA</p>
            <div class="ys-contact__social">
                <a href="https://www.facebook.com/yosuadoficial" target="_blank" rel="noopener noreferrer"
                    class="ys-contact__social-link" aria-label="Facebook">f</a>
                <a href="https://www.instagram.com/yosuadoficial" target="_blank" rel="noopener noreferrer"
                    class="ys-contact__social-link" aria-label="Instagram">in</a>
                <a href="#" class="ys-contact__social-link" aria-label="Música">♫</a>
            </div>
        </div>
    </section>

    {{-- ════════════════ FOOTER ════════════════ --}}
    <footer class="ys-footer">
        <div class="ys-footer__container">
            <div class="ys-footer__brand">
                <img src="{{ asset('img/portfolio/yosuad/bats-emblem.png') }}" alt=""
                    class="ys-footer__logo" aria-hidden="true">
                <div>
                    <p class="ys-footer__name">YOSUAD</p>
                    <p class="ys-footer__sub">Home Run · Est. 2005</p>
                </div>
            </div>
            <p class="ys-footer__quote">"Mi música no tiene stop ni precio."</p>
            <p class="ys-footer__copy">© {{ date('Y') }} Yosuad. Todos los derechos reservados.</p>
        </div>
    </footer>

</body>

</html>
