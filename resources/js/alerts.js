/* ========= SweetAlert2 — alertas desde sesión Laravel ========= */

document.addEventListener('DOMContentLoaded', () => {

    // ── Notificaciones desde sesión ──────────────────────────────────────────
    const alerts = window._alerts ?? {};

    const map = {
        success: { icon: 'success', title: '¡Listo!',   timer: 2500 },
        error:   { icon: 'error',   title: 'Error',      timer: 3500 },
        info:    { icon: 'info',    title: 'Info',        timer: 3000 },
        warning: { icon: 'warning', title: 'Atención',   timer: 3500 },
    };

    for (const [type, config] of Object.entries(map)) {
        if (alerts[type]) {
            Swal.fire({
                icon: config.icon,
                title: config.title,
                text: alerts[type],
                timer: config.timer,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
            });
        }
    }

    // ── Confirmación antes de eliminar ───────────────────────────────────────
    // Aplica a todos los forms con data-confirm
    document.querySelectorAll('form[data-confirm]').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const message = form.dataset.confirm || '¿Estás seguro de que quieres eliminar esto?';

            Swal.fire({
                title: '¿Estás seguro?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });

});