/***********************************************************/
/*       Animación Nuestro Proceso -pagina start          */
/*********************************************************/


(function () {
  'use strict';

  function initFaqAccordion() {
    var triggers = document.querySelectorAll('[data-faq-trigger]');

    if (!triggers.length) return;

    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function () {
        var item   = trigger.closest('.faq-item');
        var isOpen = item.classList.contains('faq-item--open');

        document.querySelectorAll('.faq-item--open').forEach(function (openItem) {
          openItem.classList.remove('faq-item--open');
          openItem.querySelector('[data-faq-trigger]').setAttribute('aria-expanded', 'false');
          openItem.querySelector('.faq-item__body').setAttribute('aria-hidden', 'true');
        });

        if (!isOpen) {
          item.classList.add('faq-item--open');
          trigger.setAttribute('aria-expanded', 'true');
          item.querySelector('.faq-item__body').setAttribute('aria-hidden', 'false');
        }
      });
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initFaqAccordion();
  });

})();

