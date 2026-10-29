/* ======================================================
   LEAD FORM — Formularios de contacto del sitio (AJAX)
   Maneja todos los formularios con el atributo data-lead-form:
   - Página de contacto: data-lead-form="contact-page"
   - Inicio (sección contacto): data-lead-form="start-contact"

   El valor del atributo es el prefijo BEM de las clases que se usan:
   - {prefijo}__form-input--error → campo con error (borde rojo)
   - {prefijo}__success           → mensaje de éxito (reemplaza el formulario)
   - {prefijo}__success-icon      → ícono del mensaje de éxito
   Los estilos de cada una están en el CSS de cada página.

   Dentro del formulario:
   - Cada campo lleva data-field="nombre" y su error data-error="nombre",
     con el mismo nombre que usa el servidor (first_name, whatsapp…).
   - data-error="form" es el error general (ej: página expirada).
   - El WhatsApp lo envía el campo oculto que crea phone-input.js.

   Servidor: POST leads.store → LeadController@storeContact (responde JSON)
   El formulario de Meta tiene su propio JS (js/leads/form.js) por el Pixel.
   ====================================================== */

const SUCCESS_ICON = `
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2.5"
        stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
    </svg>`;

document.querySelectorAll('form[data-lead-form]').forEach(initLeadForm);

/**
 * Prepara un formulario: envío AJAX y limpieza de errores al escribir.
 */
function initLeadForm(form) {
    const prefix = form.dataset.leadForm;

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        sendLeadForm(form, prefix);
    });

    // Al escribir o cambiar un campo, se limpia su error
    form.querySelectorAll('[data-field]').forEach((field) => {
        const clear = () => clearFieldError(form, prefix, field.dataset.field);
        field.addEventListener('input', clear);
        field.addEventListener('change', clear);
    });
}

/**
 * Envía el formulario y muestra el resultado.
 */
async function sendLeadForm(form, prefix) {
    const button = form.querySelector('button[type="submit"]');
    if (button) button.disabled = true; // evita envíos dobles

    clearAllErrors(form, prefix);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    || form.querySelector('input[name="_token"]')?.value,
                'Accept': 'application/json',
            },
            body: new FormData(form),
        });

        // 419 = la página estuvo abierta mucho tiempo y su sesión expiró
        if (response.status === 419) {
            showError(form, prefix, 'form', 'La página estuvo abierta mucho tiempo. Recárgala e intenta de nuevo.');
            return;
        }

        // 422 = errores de validación: se muestran debajo de cada campo
        if (response.status === 422) {
            const data = await response.json();
            Object.entries(data.errors || {}).forEach(([field, messages]) => {
                showError(form, prefix, field, messages[0]);
            });
            return;
        }

        if (!response.ok) {
            showError(form, prefix, 'form', 'Ocurrió un error, intenta de nuevo.');
            return;
        }

        showSuccess(form, prefix);
    } catch (error) {
        console.error('Formulario de contacto:', error);
        showError(form, prefix, 'form', 'No pudimos conectar. Revisa tu conexión e intenta de nuevo.');
    } finally {
        // Si se mostró el éxito, el botón ya no existe
        if (button && document.body.contains(button)) button.disabled = false;
    }
}

/** Muestra el error de un campo y marca el campo en rojo. */
function showError(form, prefix, field, message) {
    const errorEl = form.querySelector(`[data-error="${field}"]`);
    const fieldEl = form.querySelector(`[data-field="${field}"]`);

    if (errorEl) errorEl.textContent = message;
    if (fieldEl) fieldEl.classList.add(`${prefix}__form-input--error`);
}

/** Quita el error de un campo. */
function clearFieldError(form, prefix, field) {
    const errorEl = form.querySelector(`[data-error="${field}"]`);
    const fieldEl = form.querySelector(`[data-field="${field}"]`);

    if (errorEl) errorEl.textContent = '';
    if (fieldEl) fieldEl.classList.remove(`${prefix}__form-input--error`);
}

/** Quita todos los errores (antes de cada envío). */
function clearAllErrors(form, prefix) {
    form.querySelectorAll('[data-error]').forEach((el) => {
        el.textContent = '';
    });
    form.querySelectorAll(`.${prefix}__form-input--error`).forEach((el) => {
        el.classList.remove(`${prefix}__form-input--error`);
    });
}

/**
 * Reemplaza el formulario por el mensaje de éxito.
 * Se reemplaza el contenedor del formulario (su elemento padre).
 */
function showSuccess(form, prefix) {
    form.parentElement.innerHTML = `
        <div class="${prefix}__success">
            <div class="${prefix}__success-icon">${SUCCESS_ICON}</div>
            <h3>¡Mensaje enviado!</h3>
            <p>¡Gracias! Te contactamos en menos de 24 horas.</p>
        </div>
    `;
}