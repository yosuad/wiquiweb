@extends('layouts.app')

@section('title', 'Política de Privacidad')

@section('content')

    <!-- ════════════════ HERO ═══════════════ -->
    <section class="privacy-hero">
        <div class="privacy-hero__container">
            <p class="privacy-hero__label">Legal</p>
            <h1 class="privacy-hero__title">Política de <span class="privacy-hero__highlight">Privacidad</span></h1>
        </div>
    </section>

    <!-- ════════════════ CONTENIDO ═══════════════ -->
    <section class="privacy">
        <div class="privacy__container">

            <p class="privacy__intro">
                En <strong>WiquiWeb</strong> valoramos tu privacidad y nos comprometemos a proteger la información personal que compartes con nosotros. Esta política explica cómo recopilamos, usamos, almacenamos y protegemos tus datos.
            </p>

            <div class="privacy__block">
                <h2 class="privacy__block-title">1. Información que recopilamos</h2>
                <p class="privacy__block-text">Recopilamos información de distintas formas según la interacción que tengas con nuestros servicios:</p>
                <ul class="privacy__list">
                    <li class="privacy__list-item"><strong>Información de contacto:</strong> Nombre, correo electrónico, número de teléfono.</li>
                    <li class="privacy__list-item"><strong>Mensajes de WhatsApp:</strong> Mensajes enviados mediante la API oficial de WhatsApp Business, incluyendo contenido, archivos adjuntos y metadatos de la conversación.</li>
                    <li class="privacy__list-item"><strong>Información de uso:</strong> Dirección IP, tipo de navegador, páginas visitadas, duración de la visita, interacción con formularios y cookies.</li>
                    <li class="privacy__list-item"><strong>Datos adicionales:</strong> Información opcional que nos proporciones durante encuestas, comentarios, soporte o concursos.</li>
                </ul>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">2. Cómo usamos tu información</h2>
                <p class="privacy__block-text">La información que recopilamos se utiliza para los siguientes fines:</p>
                <ul class="privacy__list">
                    <li class="privacy__list-item">Responder a tus consultas, solicitudes de servicio y comentarios.</li>
                    <li class="privacy__list-item">Gestionar y mejorar la interacción mediante nuestro número de WhatsApp y otros canales de comunicación.</li>
                    <li class="privacy__list-item">Enviar boletines, promociones y contenido informativo solo si has dado tu consentimiento.</li>
                    <li class="privacy__list-item">Mejorar nuestro sitio web, servicios, seguridad y experiencia del usuario.</li>
                    <li class="privacy__list-item">Cumplir obligaciones legales y contractuales, así como proteger nuestros derechos e intereses.</li>
                    <li class="privacy__list-item">Realizar análisis internos sobre la utilización de nuestros servicios y generar estadísticas agregadas.</li>
                </ul>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">3. Cómo compartimos tu información</h2>
                <p class="privacy__block-text">No vendemos, alquilamos ni compartimos tu información personal con fines comerciales externos. Podemos compartir información únicamente con:</p>
                <ul class="privacy__list">
                    <li class="privacy__list-item">Proveedores de servicios autorizados que nos ayudan a gestionar la mensajería de WhatsApp, el hosting, análisis y mejoras del sitio web.</li>
                    <li class="privacy__list-item">Autoridades legales o gubernamentales si así lo exige la ley o en caso de investigaciones legítimas.</li>
                    <li class="privacy__list-item">Socios comerciales únicamente para fines directamente relacionados con la prestación de nuestros servicios, y siempre cumpliendo con las leyes de protección de datos.</li>
                </ul>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">4. Seguridad de los datos</h2>
                <p class="privacy__block-text">Implementamos medidas administrativas, técnicas y físicas razonables para proteger tu información personal contra acceso, alteración, divulgación o destrucción no autorizada. Estas incluyen cifrado de datos, almacenamiento seguro y controles de acceso restringidos.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">5. Privacidad en WhatsApp</h2>
                <p class="privacy__block-text">Los mensajes enviados a nuestro número de WhatsApp son procesados mediante la API oficial de WhatsApp Business proporcionada por Meta. Tu información puede estar sujeta a las políticas de privacidad de Meta/WhatsApp. Te recomendamos revisar sus términos en <a href="https://www.whatsapp.com/legal/privacy-policy" target="_blank" rel="noopener" class="privacy__link">whatsapp.com/legal/privacy-policy</a>.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">6. Cookies y tecnologías similares</h2>
                <p class="privacy__block-text">Utilizamos cookies y tecnologías similares para mejorar tu experiencia de navegación, analizar el tráfico del sitio web y personalizar el contenido. Puedes gestionar tus preferencias de cookies desde la configuración de tu navegador.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">7. Privacidad de los menores</h2>
                <p class="privacy__block-text">Nuestros servicios no están dirigidos a menores de 13 años. No recopilamos intencionalmente información de niños. Si detectamos que hemos recopilado datos de un menor sin consentimiento parental, los eliminaremos de inmediato.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">8. Conservación de datos</h2>
                <p class="privacy__block-text">Conservamos tus datos personales solo durante el tiempo necesario para cumplir con los fines para los cuales fueron recopilados, o según lo exija la legislación aplicable.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">9. Cambios en la política de privacidad</h2>
                <p class="privacy__block-text">Podemos actualizar esta política periódicamente para reflejar cambios en nuestras prácticas o en la legislación aplicable. Te notificaremos de cambios significativos mediante nuestro sitio web o por correo electrónico.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">10. Tus derechos</h2>
                <p class="privacy__block-text">Dependiendo de tu ubicación, puedes tener derecho a acceder, corregir, eliminar o exportar tus datos personales, así como a oponerte al procesamiento en determinados casos. Para ejercer estos derechos, contáctanos mediante <a href="mailto:soporte@wiquiweb.com" class="privacy__link">soporte@wiquiweb.com</a>.</p>
            </div>

            <div class="privacy__block">
                <h2 class="privacy__block-title">11. Contacto</h2>
                <p class="privacy__block-text">Para cualquier duda, comentario o solicitud sobre esta política, puedes escribirnos a: <a href="mailto:soporte@wiquiweb.com" class="privacy__link">soporte@wiquiweb.com</a></p>
            </div>

            <div class="privacy__updated">
                <p class="privacy__updated-text">Última actualización: 8 de febrero de 2026</p>
            </div>

        </div>
    </section>

@endsection