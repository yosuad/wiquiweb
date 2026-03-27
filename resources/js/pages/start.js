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
/*           Formulario contacto  de start — envío AJAX            */
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




/***********************************************************/
/*           Animación contadores — Stats                 */
/*********************************************************/

const counters = document.querySelectorAll('.start-stat__count');

if (counters.length) {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.textContent.replace(/\D/g, ''));
                const duration = 1500;
                const step = Math.ceil(target / (duration / 16));
                let current = 0;

                const timer = setInterval(() => {
                    current += step;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    el.textContent = '+' + current;
                }, 16);

                observer.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach(counter => observer.observe(counter));
}


 
/***********************************************************/
/*        Formulario newsletter — envío AJAX             */
/*********************************************************/
 
const newsletterForm = document.querySelector('.footer__form');
const newsletterWrapper = document.querySelector('.footer__newsletter');
 
if (newsletterForm) {
    newsletterForm.addEventListener('submit', async function (e) {
        e.preventDefault();
 
        const formData = new FormData(newsletterForm);
 
        try {
            const response = await fetch(newsletterForm.action, {
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
                    const errorMsg = data.errors?.email?.[0] || 'Ocurrió un error, intenta de nuevo.';
                    const existing = newsletterWrapper.querySelector('.footer__error');
                    if (existing) existing.remove();
 
                    const errorEl = document.createElement('p');
                    errorEl.className = 'footer__error';
                    errorEl.style.cssText = 'color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem;';
                    errorEl.textContent = errorMsg;
                    newsletterForm.after(errorEl);
                    return;
                }
 
                // Ajustar margin del texto
                const text = newsletterWrapper.querySelector('.footer__newsletter-text');
                if (text) text.style.margin = '0 auto';
 
                // Expandir el form al ancho completo
                newsletterForm.style.width = '100%';
                newsletterForm.style.maxWidth = '100%';
 
                // Mostrar mensaje de éxito
                newsletterForm.innerHTML = `
                    <div class="footer__success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <p>¡Gracias por suscribirte!</p>
                    </div>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
}