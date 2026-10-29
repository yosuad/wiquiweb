/* ======================================================
   FORMULARIO META — Envío AJAX
   Vista: views/leads/form.blade.php
   Servidor: LeadController@storeMeta (responde JSON)

   - Muestra los errores del servidor debajo de cada campo
     (busca los campos por id: #first_name, #whatsapp, #error-whatsapp…).
   - El WhatsApp lo envía el campo oculto que crea phone-input.js.
   - Meta Pixel: dispara el evento "Lead" SOLO si el envío fue exitoso.
   ====================================================== */

import { createIcons, icons } from 'lucide';

const metaForm = document.querySelector('.contact-form');
const contactWrapper = document.querySelector('.contact-wrapper');
const submitBtn = document.getElementById('submitBtn');

/** Contenido original del botón, para restaurarlo tras un error. */
const SUBMIT_LABEL = '<i data-lucide="send"></i> Enviar solicitud';

if (metaForm) {
    metaForm.addEventListener('submit', (e) => {
        e.preventDefault();
        sendForm();
    });

    // Al escribir o marcar un campo, se limpia su error
    metaForm.querySelectorAll('input[id]').forEach((input) => {
        const clear = () => clearFieldError(input.id);
        input.addEventListener('input', clear);
        input.addEventListener('change', clear);
    });
}

/**
 * Envía el formulario y muestra el resultado.
 */
async function sendForm() {
    setLoading(true);
    clearAllErrors();

    try {
        const response = await fetch(metaForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                    || metaForm.querySelector('input[name="_token"]')?.value,
                'Accept': 'application/json',
            },
            body: new FormData(metaForm),
        });

        // 419 = la página estuvo abierta mucho tiempo y su sesión expiró
        if (response.status === 419) {
            showFormError('La página estuvo abierta mucho tiempo. Recárgala e intenta de nuevo.');
            return;
        }

        // 422 = errores de validación: se muestran debajo de cada campo
        if (response.status === 422) {
            const data = await response.json();
            showFieldErrors(data.errors || {});
            return;
        }

        if (!response.ok) {
            showFormError('Ocurrió un error, intenta de nuevo.');
            return;
        }

        // Éxito: evento "Lead" para el Pixel de Meta
        if (typeof fbq !== 'undefined') {
            fbq('track', 'Lead');
        }

        showSuccess();
    } catch (error) {
        console.error('Formulario Meta:', error);
        showFormError('No pudimos conectar. Revisa tu conexión e intenta de nuevo.');
    } finally {
        // Si se mostró el éxito, el botón ya no existe
        if (document.body.contains(submitBtn)) {
            setLoading(false);
        }
    }
}

/**
 * Muestra cada error debajo de su campo y marca el campo en rojo.
 * Los ids coinciden con los nombres de los campos del servidor.
 */
function showFieldErrors(errors) {
    Object.entries(errors).forEach(([field, messages]) => {
        const errorEl = document.getElementById(`error-${field}`);
        const inputEl = document.getElementById(field);

        if (errorEl) errorEl.textContent = messages[0];
        if (inputEl) inputEl.classList.add('form-input--error');
    });
}

/** Quita el error de un campo. */
function clearFieldError(field) {
    const errorEl = document.getElementById(`error-${field}`);
    const inputEl = document.getElementById(field);

    if (errorEl) errorEl.textContent = '';
    if (inputEl) inputEl.classList.remove('form-input--error');
}

/** Quita todos los errores (antes de cada envío). */
function clearAllErrors() {
    metaForm.querySelectorAll('.form-error').forEach((el) => {
        el.textContent = '';
    });
    metaForm.querySelectorAll('.form-input--error').forEach((el) => {
        el.classList.remove('form-input--error');
    });
}

/** Muestra un error general, encima del botón. */
function showFormError(message) {
    const errorEl = document.getElementById('error-form');
    if (errorEl) errorEl.textContent = message;
}

/** Botón en estado "Enviando…" o normal. */
function setLoading(isLoading) {
    submitBtn.disabled = isLoading;

    if (isLoading) {
        submitBtn.textContent = 'Enviando...';
    } else {
        submitBtn.innerHTML = SUBMIT_LABEL;
        createIcons({ icons });
    }
}

/** Reemplaza el formulario por el mensaje de éxito. */
function showSuccess() {
    contactWrapper.innerHTML = `
        <div class="contact-success">
            <div class="contact-success__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
            <h2 class="contact-success__title">¡Mensaje enviado!</h2>
            <p class="contact-success__text">¡Gracias! Te contactamos en menos de 24 horas.</p>
        </div>
    `;
}