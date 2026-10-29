/* ======================================================
   PÁGINA DE INICIO — Interacciones
   Vista: views/site/start.blade.php
   1. Animación "Nuestro proceso"
   2. Contadores animados (estadísticas)
   (El formulario de contacto lo maneja js/components/lead-form.js
    y el newsletter del footer js/components/newsletter.js)
   ====================================================== */


/* ──────────────────────────────────────────────────────
   1. Animación "Nuestro proceso"
   Cada paso aparece con un pequeño retraso al entrar en pantalla.
   ────────────────────────────────────────────────────── */

const steps = document.querySelectorAll('.start-step');

if (steps.length) {
    const stepsObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const step = entry.target;
                const index = [...steps].indexOf(step);

                setTimeout(() => {
                    step.classList.add('is-visible');
                }, index * 150);

                stepsObserver.unobserve(step);
            }
        });
    }, { threshold: 0.2 });

    steps.forEach((step) => stepsObserver.observe(step));
}


/* ──────────────────────────────────────────────────────
   2. Contadores animados (estadísticas)
   Cuentan desde 0 hasta su valor al entrar en pantalla.
   ────────────────────────────────────────────────────── */

const counters = document.querySelectorAll('.start-stat__count');

if (counters.length) {
    const countersObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const el = entry.target;
                const target = parseInt(el.textContent.replace(/\D/g, ''));
                const duration = 1500;
                const increment = Math.ceil(target / (duration / 16));
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    el.textContent = '+' + current;
                }, 16);

                countersObserver.unobserve(el);
            }
        });
    }, { threshold: 0.5 });

    counters.forEach((counter) => countersObserver.observe(counter));
}