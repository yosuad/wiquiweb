/* ======================================================
   NEWSLETTER — Suscripción al boletín por correo (AJAX)
   Maneja todos los formularios con el atributo data-newsletter:
   - Footer (todas las páginas): data-newsletter="footer"
   - Blog:                       data-newsletter="blog-newsletter"

   El valor del atributo es el prefijo BEM de las clases que se usan:
   - {prefijo}__form--done  → se agrega al formulario tras suscribirse
   - {prefijo}__success     → mensaje de éxito (reemplaza el formulario)
   - {prefijo}__error       → mensaje de error (debajo del formulario)
   Los estilos de cada una están en el CSS de cada módulo.

   Ruta: POST subscribers.store → SubscriptionController@store (responde JSON)
   ====================================================== */

const SUCCESS_ICON = `
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2.5"
        stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"></polyline>
    </svg>`;

document.querySelectorAll('form[data-newsletter]').forEach((form) => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        subscribe(form, form.dataset.newsletter);
    });
});

/**
 * Envía el correo al servidor y muestra el resultado en el propio formulario.
 */
async function subscribe(form, prefix) {
    const button = form.querySelector('button[type="submit"]');
    if (button) button.disabled = true; // evita envíos dobles

    clearError(form, prefix);

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

        // ← NUEVO: 419 = la página estuvo abierta mucho tiempo y su sesión expiró
        if (response.status === 419) {
            showError(form, prefix, 'La página estuvo abierta mucho tiempo. Recárgala e intenta de nuevo.');
            return;
        }

        const data = await response.json();

        // 422 = error de validación (correo inválido o ya suscrito)
        if (response.status === 422) {
            showError(form, prefix, data.errors?.email?.[0] || 'Ocurrió un error, intenta de nuevo.');
            return;
        }

        if (!response.ok) {
            showError(form, prefix, 'Ocurrió un error, intenta de nuevo.');
            return;
        }

        showSuccess(form, prefix, data.message || '¡Gracias por suscribirte!');
    } catch (error) {
        console.error('Newsletter:', error);
        showError(form, prefix, 'No pudimos conectar. Revisa tu conexión e intenta de nuevo.');
    } finally {
        if (button) button.disabled = false;
    }
}

/**
 * Reemplaza el formulario por el mensaje de éxito.
 * La persona sigue en la misma página y ya no puede volver a enviar.
 */
function showSuccess(form, prefix, message) {
    form.classList.add(`${prefix}__form--done`);
    form.innerHTML = `
        <div class="${prefix}__success">
            ${SUCCESS_ICON}
            <p>${message}</p>
        </div>`;
}

/**
 * Muestra el mensaje de error justo debajo del formulario.
 */
function showError(form, prefix, message) {
    const error = document.createElement('p');
    error.className = `${prefix}__error`;
    error.textContent = message;
    form.after(error);
}

/**
 * Quita el error anterior (si lo hay) antes de un nuevo intento.
 */
function clearError(form, prefix) {
    form.parentElement.querySelector(`.${prefix}__error`)?.remove();
}