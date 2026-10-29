<?php

/*
|--------------------------------------------------------------------------
| Leads — configuración compartida
|--------------------------------------------------------------------------
|
| Lista ÚNICA de servicios de interés. La usan:
| - Formulario de contacto del sitio (selector "¿Qué necesitas?")
| - Formulario de Meta (?servicio= en el enlace del anuncio)
| - Panel: crear/editar prospecto y editar cliente
| - LeadController (validación)
|
| La clave es lo que se guarda en contacts.service_interest (no cambiarla
| si ya hay contactos con ese valor); el texto es lo que se muestra.
| Para agregar un servicio nuevo, basta con agregarlo aquí.
|
*/

return [

    'services' => [
        'pagina_web' => 'Página web',
        'landing_page' => 'Landing page',
        'correos' => 'Correos corporativos',
        'diseno' => 'Diseño gráfico',
        'campana_publicitaria' => 'Marketing digital / Campaña publicitaria',
        'asistente_virtual' => 'Asistente virtual',
        'crm' => 'CRM',
        'erp' => 'ERP',
        'otro' => 'Otro',
    ],

    // Servicio que se usa cuando no llega uno válido
    'default_service' => 'pagina_web',

];
