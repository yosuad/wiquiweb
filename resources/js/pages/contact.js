/***********************************************************/
/*        Formulario contacto — página /contacto         */
/*********************************************************/

const contactPageForm = document.querySelector('.contact-page__form');
const contactPageWrapper = document.querySelector('.contact-page__form-wrapper');

if (contactPageForm) {
    contactPageForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(contactPageForm);

        try {
            const response = await fetch(contactPageForm.action, {
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
                    console.error(data.errors);
                    return;
                }

                // Mostrar mensaje de éxito
                contactPageWrapper.innerHTML = `
                    <div class="contact-page__success">
                        <div class="contact-page__success-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <h3>¡Mensaje enviado!</h3>
                        <p>¡Gracias! Te contactamos en menos de 24 horas.</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}