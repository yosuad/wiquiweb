/***********************************************************/
/*        Formulario Meta — envío AJAX                   */
/*********************************************************/

const metaForm = document.querySelector('.contact-form');
const contactWrapper = document.querySelector('.contact-wrapper');

if (metaForm) {
    metaForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = document.querySelector('#submitBtn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';

        const formData = new FormData(metaForm);

        try {
            const response = await fetch(metaForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                        || document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            if (response.ok || response.status === 422) {
                const data = await response.json();

                if (response.status === 422) {
                    // Mostrar errores de validación
                    const errors = data.errors || {};
                    Object.keys(errors).forEach(field => {
                        const errorEl = document.querySelector(`#error-${field}`);
                        const inputEl = document.querySelector(`[name="${field}"]`);
                        if (errorEl) errorEl.textContent = errors[field][0];
                        if (inputEl) inputEl.classList.add('form-input--error');
                    });

                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar solicitud';
                    return;
                }

                // Mostrar mensaje de éxito
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
        } catch (error) {
            console.error('Error:', error);
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Enviar solicitud';
        }
    });

    // Limpiar error al escribir
    document.querySelectorAll('.form-input').forEach(input => {
        input.addEventListener('input', function () {
            const field = this.getAttribute('name');
            const errorEl = document.querySelector(`#error-${field}`);
            if (errorEl) errorEl.textContent = '';
            this.classList.remove('form-input--error');
        });
    });
}