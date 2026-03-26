@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

    <div class="beam-container beam-px-6 beam-py-8 beam-mx-auto beam-max-w-5xl">

    <h1 class="beam-text-4xl beam-font-bold beam-mb-6 beam-text-center">Política de Privacidad</h1>

    <p class="beam-text-lg beam-mb-6">
        En <strong>WiquiWeb</strong> valoramos tu privacidad y nos comprometemos a proteger la información personal que compartes
        con nosotros. Esta política de privacidad explica cómo recopilamos, usamos, almacenamos y protegemos tus datos cuando
        interactúas con nuestro sitio web y con nuestro número de WhatsApp a través de la API oficial de WhatsApp Business.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">1. Información que recopilamos</h2>
    <p class="beam-mb-4">Recopilamos información de distintas formas según la interacción que tengas con nuestros servicios:</p>
    <ul class="beam-list-disc beam-ml-6 beam-mb-6">
        <li><strong>Información de contacto:</strong> Nombre, correo electrónico, número de teléfono y otra información que nos proporcionas al contactarnos o suscribirte a boletines.</li>
        <li><strong>Mensajes de WhatsApp:</strong> Mensajes que envías a nuestro número mediante la API oficial de WhatsApp Business, incluyendo contenido, archivos adjuntos y metadatos de la conversación.</li>
        <li><strong>Información de uso:</strong> Datos generados automáticamente al visitar nuestro sitio web, como dirección IP, tipo de navegador, páginas visitadas, duración de la visita, interacción con formularios y cookies.</li>
        <li><strong>Datos adicionales:</strong> Información opcional que nos proporciones durante encuestas, comentarios, soporte o concursos.</li>
    </ul>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">2. Cómo usamos tu información</h2>
    <p class="beam-mb-4">La información que recopilamos se utiliza para los siguientes fines:</p>
    <ul class="beam-list-disc beam-ml-6 beam-mb-6">
        <li>Responder a tus consultas, solicitudes de servicio y comentarios.</li>
        <li>Gestionar y mejorar la interacción mediante nuestro número de WhatsApp y otros canales de comunicación.</li>
        <li>Enviar boletines, promociones y contenido informativo solo si has dado tu consentimiento.</li>
        <li>Mejorar nuestro sitio web, servicios, seguridad y experiencia del usuario.</li>
        <li>Cumplir obligaciones legales y contractuales, así como proteger nuestros derechos e intereses.</li>
        <li>Realizar análisis internos sobre la utilización de nuestros servicios y generar estadísticas agregadas.</li>
    </ul>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">3. Cómo compartimos tu información</h2>
    <p class="beam-mb-4">No vendemos, alquilamos ni compartimos tu información personal con fines comerciales externos. Podemos compartir información únicamente con:</p>
    <ul class="beam-list-disc beam-ml-6 beam-mb-6">
        <li>Proveedores de servicios autorizados que nos ayudan a gestionar la mensajería de WhatsApp, el hosting, análisis y mejoras del sitio web.</li>
        <li>Autoridades legales o gubernamentales si así lo exige la ley o en caso de investigaciones legítimas.</li>
        <li>Socios comerciales únicamente para fines directamente relacionados con la prestación de nuestros servicios, y siempre cumpliendo con las leyes de protección de datos.</li>
    </ul>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">4. Seguridad de los datos</h2>
    <p class="beam-mb-6">
        Implementamos medidas administrativas, técnicas y físicas razonables para proteger tu información personal contra acceso, alteración,
        divulgación o destrucción no autorizada. Estas incluyen cifrado de datos, almacenamiento seguro y controles de acceso restringidos.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">5. Privacidad en WhatsApp</h2>
    <p class="beam-mb-6">
        Los mensajes que envías a nuestro número de WhatsApp se almacenan y procesan mediante la API oficial de WhatsApp Business proporcionada por Meta.
        Al enviarnos mensajes, aceptas que estos sean procesados para responder a tus solicitudes y gestionar nuestros servicios. No compartimos tus mensajes
        con terceros fuera del alcance de nuestra prestación de servicios.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">6. Cookies y tecnologías similares</h2>
    <p class="beam-mb-6">
        Utilizamos cookies y tecnologías similares para mejorar tu experiencia en el sitio, analizar el tráfico, y personalizar contenido y anuncios.
        Puedes gestionar o deshabilitar las cookies a través de la configuración de tu navegador, pero esto puede afectar la funcionalidad de nuestro sitio.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">7. Privacidad de los menores</h2>
    <p class="beam-mb-6">
        Nuestros servicios no están dirigidos a menores de 13 años y no recopilamos conscientemente información de niños. Si descubrimos que hemos recopilado
        información de un menor sin consentimiento, tomaremos medidas inmediatas para eliminarla.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">8. Conservación de datos</h2>
    <p class="beam-mb-6">
        Conservamos tus datos solo durante el tiempo necesario para cumplir con los fines establecidos en esta política y conforme a los requisitos legales aplicables.
        Una vez cumplido este periodo, eliminamos o anonimizar los datos de forma segura.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">9. Cambios en la política de privacidad</h2>
    <p class="beam-mb-6">
        Podemos actualizar esta política de privacidad de vez en cuando para reflejar cambios en nuestras prácticas, servicios o leyes aplicables.
        Publicaremos la fecha de la última actualización y recomendamos revisarla periódicamente.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">10. Tus derechos</h2>
    <p class="beam-mb-6">
        Tienes derecho a acceder, corregir o eliminar tus datos personales, así como a oponerte al procesamiento en determinados casos.
        Para ejercer estos derechos, contáctanos mediante <a href="mailto:soporte@wiquiweb.com" class="beam-text-blue-600 beam-underline">soporte@wiquiweb.com</a>.
    </p>

    <h2 class="beam-text-2xl beam-font-semibold beam-mb-4">11. Contacto</h2>
    <p class="beam-mb-6">
        Para cualquier duda, comentario o solicitud sobre esta política de privacidad, puedes escribirnos a:
        <a href="mailto:soporte@wiquiweb.com" class="beam-text-blue-600 beam-underline">soporte@wiquiweb.com</a>
    </p>

    <p class="beam-text-sm beam-text-gray-500 beam-text-center">Última actualización: 8 de febrero de 2026</p>

</div>
@endsection
