/**
 * service-web-design.js
 * Lógica de la página: Diseño de Páginas Web
 *
 * Funcionalidades:
 *   - FAQ accordion con accesibilidad (aria-expanded / aria-hidden)
 */

(function () {
  'use strict';

  /* ── FAQ Accordion ── */

  function initFaqAccordion() {
    var triggers = document.querySelectorAll('[data-faq-trigger]');

    if (!triggers.length) return;

    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        var item   = trigger.closest('.faq-item');
        var isOpen = item.classList.contains('faq-item--open');

        // Cierra todos los ítems abiertos
        document.querySelectorAll('.faq-item--open').forEach(function (openItem) {
          openItem.classList.remove('faq-item--open');
          openItem.querySelector('[data-faq-trigger]').setAttribute('aria-expanded', 'false');
          openItem.querySelector('.faq-item__body').setAttribute('aria-hidden', 'true');
        });

        // Si el ítem estaba cerrado, lo abre
        if (!isOpen) {
          item.classList.add('faq-item--open');
          trigger.setAttribute('aria-expanded', 'true');
          item.querySelector('.faq-item__body').setAttribute('aria-hidden', 'false');
        }
      });
    });
  }

  /* ── Init ── */

  document.addEventListener('DOMContentLoaded', function () {
    initFaqAccordion();
  });

})();
