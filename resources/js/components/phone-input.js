/* ======================================================
   PHONE INPUT — Teléfono internacional con selector de país
   Librería: intl-tel-input v29 (npm, local)

   Uso en Blade: <x-phone-input name="whatsapp" class="..." />
   (el componente agrega data-phone-input y data-country)

   Cómo funciona:
   - El campo visible muestra la bandera y el número como lo escribe el cliente.
   - Un campo oculto con el mismo "name" envía el número en formato
     internacional E.164 (+573205693258). Eso es lo que recibe el servidor.
   - El país inicial viene de data-country: ?pais=mx en la URL,
     o el país del visitante según Cloudflare, o Colombia por defecto.

   Este archivo solo se descarga en páginas con un campo de teléfono
   (ver app.js).
   ====================================================== */

import intlTelInput from 'intl-tel-input/intlTelInputWithUtils';
import es from 'intl-tel-input/locale/es';
import 'intl-tel-input/styles';
import '../../css/components/phone-input.css';

/** País por defecto si no se detecta otro (70% de los leads son de Colombia). */
const DEFAULT_COUNTRY = 'co';

/** Países de las campañas: aparecen primero en la lista del selector. */
const PRIORITY_COUNTRIES = ['co', 'us', 'mx', 'cr', 'pa', 'au', 'es'];

document.querySelectorAll('input[data-phone-input]').forEach(initPhoneInput);

/**
 * Convierte un input normal en un campo de teléfono internacional.
 */
function initPhoneInput(input) {
    const iti = intlTelInput(input, {
        initialCountry: resolveCountry(input.dataset.country),
        countryOrder: PRIORITY_COUNTRIES,
        separateDialCode: true,   // muestra "+57" al lado de la bandera
        strictMode: true,         // no deja escribir letras ni dígitos de más
        i18n: es,                 // nombres de países en español
    });

    // Campo oculto: es el que envía el número al servidor.
    // El visible pierde su "name" para que no se envíe dos veces.
    const hidden = document.createElement('input');
    hidden.type = 'hidden';
    hidden.name = input.name;
    input.removeAttribute('name');
    input.after(hidden);

    // Mantiene el campo oculto siempre actualizado (al escribir y al cambiar de país)
    const sync = () => {
        hidden.value = iti.getNumber() || input.value.trim();
    };

    input.addEventListener('input', sync);
    input.addEventListener('countrychange', sync);
    input.addEventListener('blur', sync);
    sync();
}

/**
 * Devuelve un código de país válido (2 letras en minúscula).
 * Cloudflare envía "XX" o "T1" cuando no reconoce el país: en ese caso
 * se usa Colombia.
 */
function resolveCountry(country) {
    const code = (country || '').toLowerCase();

    return /^[a-z]{2}$/.test(code) && !['xx', 't1'].includes(code)
        ? code
        : DEFAULT_COUNTRY;
}