<!-- START NAVBAR -->
<header class="navbar">
    <div class="navbar__container">

        <!-- Logo -->
        <div class="navbar__logo">
            <a href="{{ url('/') }}" class="navbar__logo-link">
                <img src="{{ asset('img/logo_wiquiweb.png') }}" alt="Logo del sitio" class="navbar__logo-img">
            </a>
        </div>

        <!-- Main Menu -->
        <div class="navbar__menu">
            <nav class="navbar__nav">
                <ul class="navbar__list">
                    <li class="navbar__item">
                        <a href="{{ url('/') }}" class="navbar__link">inicio</a>
                    </li>
                    <li class="navbar__item">
                        <a href="{{ url('nosotros') }}" class="navbar__link">nosotros</a>
                    </li>
                    <li class="navbar__item navbar__item--has-children">
                        <a href="#" class="navbar__link">servicios</a>
                        <ul class="navbar__submenu">
                            <li class="navbar__submenu-item">
                                <a href="blog-details.html" class="navbar__submenu-link">
                                    <x-icon-bowl />
                                    correos
                                </a>
                            </li>
                            <li class="navbar__submenu-item">
                                <a href="portfolio-details.html" class="navbar__submenu-link">
                                    <x-icon-bowl />
                                    diseño
                                </a>
                            </li>
                            <li class="navbar__submenu-item">
                                <a href="404.html" class="navbar__submenu-link">
                                    <x-icon-bowl />
                                    consultoría
                                </a>
                            </li>
                            <li class="navbar__submenu-item">
                                <a href="404.html" class="navbar__submenu-link">
                                    <x-icon-bowl />
                                    diseño páginas web
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="navbar__item">
                        <a href="blog.html" class="navbar__link">portafolio</a>
                    </li>
                    <li class="navbar__item">
                        <a href="contact.html" class="navbar__link">blog</a>
                    </li>
                    <li class="navbar__item">
                        <a href="contact.html" class="navbar__link">contacto</a>
                    </li>
                </ul>
            </nav>
        </div>

        <!-- Buttons -->
        <div class="navbar__actions">
            <a href="{{ route('login') }}" class="navbar__btn navbar__btn--primary">Iniciar sesión</a>
            <a href="{{ route('register') }}" class="navbar__btn navbar__btn--outline">Registrarse</a>
        </div>

        <!-- Botón Hamburguesa -->
        <button class="navbar__toggle" aria-label="Abrir menú">
            <span class="navbar__toggle-line"></span>
            <span class="navbar__toggle-line"></span>
            <span class="navbar__toggle-line"></span>
        </button>

        <!-- Menu Móvil -->
        <nav class="navbar__mobile" aria-label="Menú móvil">
            <ul class="navbar__mobile-list">
                <li class="navbar__mobile-item">
                    <a href="{{ url('/') }}" class="navbar__mobile-link">inicio</a>
                </li>
                <li class="navbar__mobile-item">
                    <a href="{{ url('nosotros') }}" class="navbar__mobile-link">nosotros</a>
                </li>
                <li class="navbar__mobile-item navbar__mobile-item--has-children">
                    <a href="#" class="navbar__mobile-link">servicios</a>
                    <ul class="navbar__mobile-submenu">
                        <li class="navbar__mobile-submenu-item">
                            <a href="blog-details.html" class="navbar__mobile-submenu-link">correos</a>
                        </li>
                        <li class="navbar__mobile-submenu-item">
                            <a href="portfolio-details.html" class="navbar__mobile-submenu-link">diseño</a>
                        </li>
                        <li class="navbar__mobile-submenu-item">
                            <a href="404.html" class="navbar__mobile-submenu-link">consultoría</a>
                        </li>
                        <li class="navbar__mobile-submenu-item">
                            <a href="404.html" class="navbar__mobile-submenu-link">diseño páginas web</a>
                        </li>
                    </ul>
                </li>
                <li class="navbar__mobile-item">
                    <a href="blog.html" class="navbar__mobile-link">portafolio</a>
                </li>
                <li class="navbar__mobile-item">
                    <a href="contact.html" class="navbar__mobile-link">blog</a>
                </li>
                <li class="navbar__mobile-item">
                    <a href="contact.html" class="navbar__mobile-link">contacto</a>
                </li>
            </ul>
        </nav>

    </div>
</header>
<!-- END NAVBAR -->