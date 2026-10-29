/* ======================================================
   BLOG — Categorías (panel admin)
   Botón "Editar" (lápiz): abre una ventana para cambiar
   el nombre de la categoría y la guarda sin salir de la página.
   Vista: views/admin/blog/categories/index.blade.php
   ====================================================== */

import Swal from 'sweetalert2';

document.querySelectorAll('.js-category-edit').forEach((button) => {
    button.addEventListener('click', () => editCategory(button));
});

/**
 * Pide el nuevo nombre y, si se confirma, lo envía al servidor.
 * Los datos vienen del propio botón:
 * - data-name: nombre actual (aparece escrito en el campo)
 * - data-url:  ruta para actualizar (blog.categories.update)
 */
async function editCategory(button) {
    const { isConfirmed, value: name } = await Swal.fire({
        title: 'Editar categoría',
        input: 'text',
        inputLabel: 'Nombre',
        inputValue: button.dataset.name,
        showCancelButton: true,
        confirmButtonText: 'Guardar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#189dbb',
        cancelButtonColor: '#6b7280',
        inputValidator: (value) => (!value.trim() ? 'El nombre no puede estar vacío.' : null),
    });

    if (!isConfirmed) return;

    submitUpdate(button.dataset.url, name.trim());
}

/**
 * Crea un formulario oculto con método PATCH y lo envía.
 * Así Laravel lo recibe igual que un formulario normal,
 * y el mensaje de éxito lo muestra alerts.js.
 */
function submitUpdate(url, name) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;

    const fields = {
        _token: document.querySelector('meta[name="csrf-token"]')?.content ?? '',
        _method: 'PATCH',
        name,
    };

    Object.entries(fields).forEach(([key, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });

    document.body.appendChild(form);
    form.submit();
}