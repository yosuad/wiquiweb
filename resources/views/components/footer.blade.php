{{-- ═══════════════ FOOTER ═══════════════ --}}
<footer class="footer">
    <div class="footer__container">
        <div class="footer__main">

            <div class="footer__newsletter">
                <h2 class="footer__newsletter-title">¡Contáctanos!</h2>
                <p class="footer__newsletter-text">¡Gracias por tu interés en mantenerte informado sobre nuestras ofertas, nuevas tecnologías y desarrollos web! Si deseas recibir actualizaciones y contenido exclusivo, déjanos tu correo electrónico:</p>
                <form class="footer__form">
                    <div class="footer__input-wrapper">
                        <i data-lucide="mail" class="footer__input-icon"></i>
                        <input type="email" placeholder="Correo Electrónico" class="footer__input" required>
                    </div>
                    <button type="submit" class="footer__btn">
                        <i data-lucide="send" class="footer__btn-icon"></i>
                    </button>
                </form>
            </div>

            <div class="footer__links">
                <div class="footer__links-group">
                    <h3 class="footer__links-title">Servicios</h3>
                    <ul class="footer__links-list">
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Diseño web</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Actualizaciones</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Correos corporativos</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Creación contenido</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Campañas</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Capacitaciones</a></li>
                    </ul>
                </div>
                <div class="footer__links-group">
                    <h3 class="footer__links-title">Recursos</h3>
                    <ul class="footer__links-list">
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Blog</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Formación</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Portafolio</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Marketing</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Consultoría</a></li>
                    </ul>
                </div>
                <div class="footer__links-group">
                    <h3 class="footer__links-title">Soporte</h3>
                    <ul class="footer__links-list">
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Contacto</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Política de privacidad</a></li>
                        <li class="footer__links-item"><a href="#" class="footer__links-link">Términos de uso</a></li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="footer__bottom">
            <p class="footer__bottom-text">© 2024. Todos los derechos reservados wiquiweb</p>
            <div class="footer__bottom-links">
                <a href="{{ route('privacy') }}" class="footer__bottom-link">Política de privacidad</a>
                <a href="#" class="footer__bottom-link">Términos de uso</a>
            </div>
        </div>
    </div>
</footer>

{{-- ═══════════════ WHATSAPP BUTTON ═══════════════ --}}
<a href="https://api.whatsapp.com/send?phone=+573506396283&text=Me%20interesan%20sus%20servicios%20y%20me%20gustar%C3%ADa%20obtener%20m%C3%A1s%20informaci%C3%B3n."
    target="_blank"
    rel="noopener noreferrer"
    class="whatsapp-btn"
    aria-label="Contactar por WhatsApp">
    <svg class="whatsapp-btn__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
        <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
    </svg>
</a>