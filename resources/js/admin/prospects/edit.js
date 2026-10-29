/* ======================================================
   PROSPECTOS — Editar
   Vista: views/admin/prospects/edit.blade.php

   Al elegir "Cliente" en el estado, muestra el asterisco (*) en los
   campos que pasan a ser obligatorios.
   Solo es una ayuda visual: la regla real la valida el servidor
   (ContactController@update → required_if:status,customer).

   Los asteriscos están en la vista, ocultos, con el atributo
   data-customer-required.
   ====================================================== */

const statusSelect = document.getElementById('status');

if (statusSelect) {
    const marks = document.querySelectorAll('[data-customer-required]');

    // Muestra los asteriscos solo cuando el estado elegido es "Cliente"
    const toggleMarks = () => {
        const isCustomer = statusSelect.value === 'customer';
        marks.forEach((mark) => {
            mark.hidden = !isCustomer;
        });
    };

    statusSelect.addEventListener('change', toggleMarks);
    toggleMarks(); // al cargar, por si ya está en "Cliente"
}