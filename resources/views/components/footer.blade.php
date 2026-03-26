{{-- ═══════════════ FOOTER ═══════════════ --}}
<footer class="footer">
    <div class="footer__container">

        {{-- ===== Newsletter — siempre visible ===== --}}
        <div class="footer__newsletter">
            <h2 class="footer__newsletter-title">¡Contáctanos!</h2>
            <p class="footer__newsletter-text">Si deseas recibir actualizaciones y contenido exclusivo, déjanos tu correo electrónico:</p>

            @if(session('success'))
                <p style="color: var(--secondary-color); font-size: 0.875rem; margin-bottom: 0.75rem;">
                    {{ session('success') }}
                </p>
            @endif

            @if($errors->has('email'))
                <p style="color: var(--danger); font-size: 0.875rem; margin-bottom: 0.75rem;">
                    {{ $errors->first('email') }}
                </p>
            @endif

            <form class="footer__form" method="POST" action="{{ route('subscribers.store') }}">
                @csrf
                <div class="footer__input-wrapper">
                    <i data-lucide="mail" class="footer__input-icon"></i>
                    <input type="email" name="email" placeholder="Correo Electrónico"
                        class="footer__input" required value="{{ old('email') }}">
                </div>
                <button type="submit" class="footer__btn">
                    <i data-lucide="send" class="footer__btn-icon"></i>
                </button>
            </form>
        </div>

        {{-- ===== Main — Brand + columnas ===== --}}
        <div class="footer__main">

            {{-- Brand --}}
            <div class="footer__brand">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('img/logo_wiquiweb_white.webp') }}" alt="WiquiWeb" class="footer__brand-img">
                </a>
                <p class="footer__brand-text">Agencia de diseño y desarrollo web. Creamos presencias digitales que conectan tu marca con el mundo.</p>
                <div class="footer__social">
                    <a href="https://www.facebook.com/wiquieb" target="_blank" rel="noopener" class="footer__social-link" aria-label="Facebook">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor"><path d="M80 299.3l0 212.7 116 0 0-212.7 86.5 0 18-97.8-104.5 0 0-34.6c0-51.7 20.3-71.5 72.7-71.5 16.3 0 29.4 .4 37 1.2l0-88.7C291.4 4 256.4 0 236.2 0 129.3 0 80 50.5 80 159.4l0 42.1-66 0 0 97.8 66 0z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/wiquiweb" target="_blank" rel="noopener" class="footer__social-link" aria-label="Instagram">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M224.3 141a115 115 0 1 0 -.6 230 115 115 0 1 0 .6-230zm-.6 40.4a74.6 74.6 0 1 1 .6 149.2 74.6 74.6 0 1 1 -.6-149.2zm93.4-45.1a26.8 26.8 0 1 1 53.6 0 26.8 26.8 0 1 1 -53.6 0zm129.7 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM399 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
                    </a>
                    <a href="https://www.tiktok.com/@wiquiweb" target="_blank" rel="noopener" class="footer__social-link" aria-label="TikTok">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M448.5 209.9c-44 .1-87-13.6-122.8-39.2l0 178.7c0 33.1-10.1 65.4-29 92.6s-45.6 48-76.6 59.6-64.8 13.5-96.9 5.3-60.9-25.9-82.7-50.8-35.3-56-39-88.9 2.9-66.1 18.6-95.2 40-52.7 69.6-67.7 62.9-20.5 95.7-16l0 89.9c-15-4.7-31.1-4.6-46 .4s-27.9 14.6-37 27.3-14 28.1-13.9 43.9 5.2 31 14.5 43.7 22.4 22.1 37.4 26.9 31.1 4.8 46-.1 28-14.4 37.2-27.1 14.2-28.1 14.2-43.8l0-349.4 88 0c-.1 7.4 .6 14.9 1.9 22.2 3.1 16.3 9.4 31.9 18.7 45.7s21.3 25.6 35.2 34.6c19.9 13.1 43.2 20.1 67 20.1l0 87.4z"/></svg>
                    </a>
                    <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" rel="noopener" class="footer__social-link" aria-label="LinkedIn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor"><path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/></svg>
                    </a>
                    <a href="https://www.youtube.com/@wiquiweb" target="_blank" rel="noopener" class="footer__social-link" aria-label="YouTube">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor"><path d="M549.7 124.1C543.5 100.4 524.9 81.8 501.4 75.5 458.9 64 288.1 64 288.1 64S117.3 64 74.7 75.5C51.2 81.8 32.7 100.4 26.4 124.1 15 167 15 256.4 15 256.4s0 89.4 11.4 132.3c6.3 23.6 24.8 41.5 48.3 47.8 42.6 11.5 213.4 11.5 213.4 11.5s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zM232.2 337.6l0-162.4 142.7 81.2-142.7 81.2z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Columna Servicios --}}
            <div class="footer__col">
                <h3 class="footer__col-title">Servicios</h3>
                <ul class="footer__col-list">
                    <li><a href="{{ route('services.web-design') }}" class="footer__col-link">Diseño Web</a></li>
                    <li><a href="#servicios" class="footer__col-link">Diseño Gráfico</a></li>
                    <li><a href="#servicios" class="footer__col-link">Correos Corporativos</a></li>
                    <li><a href="#servicios" class="footer__col-link">Actualizaciones Web</a></li>
                    <li><a href="#servicios" class="footer__col-link">Gestión Empresarial</a></li>
                    <li><a href="#servicios" class="footer__col-link">Marketing Digital</a></li>
                </ul>
            </div>

            {{-- Columna Empresa --}}
            <div class="footer__col">
                <h3 class="footer__col-title">Empresa</h3>
                <ul class="footer__col-list">
                    <li><a href="{{ url('nosotros') }}" class="footer__col-link">Nosotros</a></li>
                    <li><a href="#portafolio" class="footer__col-link">Portafolio</a></li>
                    <li><a href="#testimonios" class="footer__col-link">Reseñas</a></li>
                    <li><a href="#contacto" class="footer__col-link">Contacto</a></li>                   
                </ul>
            </div>

        </div>

        {{-- ===== Bottom ===== --}}
        <div class="footer__bottom">
            <p class="footer__bottom-text">© {{ date('Y') }}. Todos los derechos reservados wiquiweb</p>
            <div class="footer__bottom-links">
                <a href="{{ route('privacy') }}" class="footer__bottom-link">Política de privacidad</a>
                <a href="#" class="footer__bottom-link">Términos de uso</a>
            </div>
        </div>

    </div>
</footer>