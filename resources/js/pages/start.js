/***********************************************************/
/*       Animación Nuestro Proceso -pagina start          */
/*********************************************************/

const steps = document.querySelectorAll('.start-step');

if (steps.length) {
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const step = entry.target;
        const index = [...steps].indexOf(step);
        setTimeout(() => {
          step.classList.add('is-visible');
        }, index * 150);
        observer.unobserve(step);
      }
    });
  }, { threshold: 0.2 });

  steps.forEach(step => observer.observe(step));
}


/***********************************************************/
/*           Formulario contacto — envío AJAX            */
/*********************************************************/

const contactForm = document.querySelector('.start-contact__form');
const formWrapper = document.querySelector('.start-contact__form-wrapper');

if (contactForm) {
    contactForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(contactForm);

        try {
            const response = await fetch(contactForm.action, {
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
                    // Errores de validación
                    console.error(data.errors);
                    return;
                }

                // Mostrar mensaje de éxito
                formWrapper.innerHTML = `
                    <div class="start-contact__success">
                        <div class="start-contact__success__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" 
                                fill="none" stroke="currentColor" stroke-width="2.5" 
                                stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <h3>¡Mensaje enviado!</h3>
                        <p>¡Gracias! Te contactamos en menos de 24 horas.</p>
                    </div>
                `;

// Apuntar createIcons al contenedor específico
lucide.createIcons({ 
    nameAttr: 'data-lucide',
    attrs: { 'stroke-width': 2 },
    nodes: formWrapper.querySelectorAll('[data-lucide]')
});
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}