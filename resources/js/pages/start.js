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
                        <i data-lucide="circle-check"></i>
                        <h3>¡Mensaje enviado!</h3>
                        <p>¡Gracias! Te contactamos en menos de 24 horas.</p>
                    </div>
                `;
                lucide.createIcons();
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}