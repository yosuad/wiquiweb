@extends('layouts.app')

@section('title', 'Contacto — Wiquiweb')

@section('content')

<section class="contact-page">
    <div class="contact-page__container">

        {{-- Header --}}
        <div class="contact-page__header">
            <p class="contact-page__subtitle">¿Listo para empezar?</p>
            <h1 class="contact-page__title">Hablemos de tu <span class="contact-page__title-highlight">proyecto</span></h1>
            <p class="contact-page__description">Cuéntanos qué necesitas y te contactamos en menos de 24 horas.</p>
        </div>

        <div class="contact-page__grid">

            {{-- Formulario --}}
            <div class="contact-page__form-wrapper">

                @if(session('contact_success'))
                    <div class="contact-page__success">
                        <div class="contact-page__success-icon">
                            <i data-lucide="circle-check"></i>
                        </div>
                        <h3>¡Mensaje enviado!</h3>
                        <p>¡Gracias! Te contactamos en menos de 24 horas.</p>
                    </div>
                @else
                    <form class="contact-page__form" method="POST" action="{{ route('leads.store') }}">
                        @csrf
                        <input type="hidden" name="origin" value="web">

                        <div class="contact-page__form-row">
                            <div class="contact-page__form-group">
                                <label class="contact-page__form-label">Nombre</label>
                                <input type="text" name="first_name" class="contact-page__form-input"
                                    placeholder="Tu nombre" maxlength="50" required>
                            </div>
                            <div class="contact-page__form-group">
                                <label class="contact-page__form-label">Apellido</label>
                                <input type="text" name="last_name" class="contact-page__form-input"
                                    placeholder="Tu apellido" maxlength="50">
                            </div>
                        </div>

                        <div class="contact-page__form-group">
                            <label class="contact-page__form-label">WhatsApp</label>
                            <input type="tel" name="whatsapp" class="contact-page__form-input"
                                placeholder="+57 320 413 25 00" maxlength="20" required>
                        </div>

                        <div class="contact-page__form-group">
                            <label class="contact-page__form-label">Correo electrónico</label>
                            <input type="email" name="email" class="contact-page__form-input"
                                placeholder="tu@correo.com" maxlength="100">
                        </div>

                        <div class="contact-page__form-group">
                            <label class="contact-page__form-label">¿Qué necesitas?</label>
                            <select name="service_interest" class="contact-page__form-input">
                                <option value="pagina_web">Página web</option>
                                <option value="correos">Correos corporativos</option>
                                <option value="diseno_grafico">Diseño gráfico</option>
                                <option value="marketing">Marketing digital</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="contact-page__form-privacy">
                            <input type="checkbox" id="privacy_contact" name="privacy" required>
                            <label for="privacy_contact">
                                He leído y acepto la
                                <a href="{{ route('privacy') }}" target="_blank">Política de Privacidad</a>
                            </label>
                        </div>

                        <button type="submit" class="contact-page__form-btn">
                            <i data-lucide="send"></i>
                            Enviar mensaje
                        </button>
                    </form>
                @endif
            </div>

            {{-- Info --}}
            <div class="contact-page__info">

                {{-- WhatsApp --}}
                <a href="https://api.whatsapp.com/send?phone=+573205864135&text=Me%20interesan%20sus%20servicios%20y%20me%20gustar%C3%ADa%20obtener%20m%C3%A1s%20informaci%C3%B3n."
                    target="_blank" rel="noopener noreferrer" class="contact-page__channel">
                    <div class="contact-page__channel-icon contact-page__channel-icon--whatsapp">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                    </div>
                    <div class="contact-page__channel-body">
                        <span class="contact-page__channel-label">WhatsApp</span>
                        <span class="contact-page__channel-value">+57 320 586 41 35</span>
                    </div>
                </a>

                {{-- Email --}}
                <a href="mailto:soporte@wiquiweb.com" class="contact-page__channel">
                    <div class="contact-page__channel-icon contact-page__channel-icon--email">
                        <i data-lucide="mail"></i>
                    </div>
                    <div class="contact-page__channel-body">
                        <span class="contact-page__channel-label">Email</span>
                        <span class="contact-page__channel-value">soporte@wiquiweb.com</span>
                    </div>
                </a>

                {{-- Redes sociales --}}
                <div class="contact-page__social">
                    <p class="contact-page__social-title">Síguenos en redes</p>
                    <div class="contact-page__social-grid">

                        <a href="https://www.facebook.com/wiquieb" target="_blank" class="contact-page__social-link" aria-label="Facebook">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" fill="currentColor">
                                <path d="M80 299.3l0 212.7 116 0 0-212.7 86.5 0 18-97.8-104.5 0 0-34.6c0-51.7 20.3-71.5 72.7-71.5 16.3 0 29.4 .4 37 1.2l0-88.7C291.4 4 256.4 0 236.2 0 129.3 0 80 50.5 80 159.4l0 42.1-66 0 0 97.8 66 0z"/>
                            </svg>
                        </a>

                        <a href="https://www.instagram.com/wiquiweb" target="_blank" class="contact-page__social-link" aria-label="Instagram">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                <path d="M224.3 141a115 115 0 1 0 -.6 230 115 115 0 1 0 .6-230zm-.6 40.4a74.6 74.6 0 1 1 .6 149.2 74.6 74.6 0 1 1 -.6-149.2zm93.4-45.1a26.8 26.8 0 1 1 53.6 0 26.8 26.8 0 1 1 -53.6 0zm129.7 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM399 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/>
                            </svg>
                        </a>

                        <a href="https://www.tiktok.com/@wiquiweb" target="_blank" class="contact-page__social-link" aria-label="TikTok">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                <path d="M448.5 209.9c-44 .1-87-13.6-122.8-39.2l0 178.7c0 33.1-10.1 65.4-29 92.6s-45.6 48-76.6 59.6-64.8 13.5-96.9 5.3-60.9-25.9-82.7-50.8-35.3-56-39-88.9 2.9-66.1 18.6-95.2 40-52.7 69.6-67.7 62.9-20.5 95.7-16l0 89.9c-15-4.7-31.1-4.6-46 .4s-27.9 14.6-37 27.3-14 28.1-13.9 43.9 5.2 31 14.5 43.7 22.4 22.1 37.4 26.9 31.1 4.8 46-.1 28-14.4 37.2-27.1 14.2-28.1 14.2-43.8l0-349.4 88 0c-.1 7.4 .6 14.9 1.9 22.2 3.1 16.3 9.4 31.9 18.7 45.7s21.3 25.6 35.2 34.6c19.9 13.1 43.2 20.1 67 20.1l0 87.4z"/>
                            </svg>
                        </a>

                        <a href="https://co.linkedin.com/company/wiqui-web" target="_blank" class="contact-page__social-link" aria-label="LinkedIn">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="currentColor">
                                <path d="M100.3 448l-92.9 0 0-299.1 92.9 0 0 299.1zM53.8 108.1C24.1 108.1 0 83.5 0 53.8 0 39.5 5.7 25.9 15.8 15.8s23.8-15.8 38-15.8 27.9 5.7 38 15.8 15.8 23.8 15.8 38c0 29.7-24.1 54.3-53.8 54.3zM447.9 448l-92.7 0 0-145.6c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7l0 148.1-92.8 0 0-299.1 89.1 0 0 40.8 1.3 0c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3l0 164.3-.1 0z"/>
                            </svg>
                        </a>

                        <a href="https://www.youtube.com/@wiquiweb" target="_blank" class="contact-page__social-link" aria-label="YouTube">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" fill="currentColor">
                                <path d="M549.7 124.1C543.5 100.4 524.9 81.8 501.4 75.5 458.9 64 288.1 64 288.1 64S117.3 64 74.7 75.5C51.2 81.8 32.7 100.4 26.4 124.1 15 167 15 256.4 15 256.4s0 89.4 11.4 132.3c6.3 23.6 24.8 41.5 48.3 47.8 42.6 11.5 213.4 11.5 213.4 11.5s170.8 0 213.4-11.5c23.5-6.3 42-24.2 48.3-47.8 11.4-42.9 11.4-132.3 11.4-132.3s0-89.4-11.4-132.3zM232.2 337.6l0-162.4 142.7 81.2-142.7 81.2z"/>
                            </svg>
                        </a>

                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

@endsection