/* ========= FONT AWESOME ========= */
import '@fortawesome/fontawesome-free/js/all.js';

/* ========= Carga AlpineJS y lo inicializa ========= */
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/* ========= Estilos globales ========= */
import '../css/app.css';

/* ========= navegacion ========= */
import '../css/components/navbar.css';

/* ========= page ========= */
import '../css/pages/start.css';

/* ========= Componentes ========= */
import '../css/components/navigation.css';
import '../css/components/sidebar.css';
import '../css/admin/dashboard.css';
import '../css/admin/tables.css';
import '../css/admin/create.css';
import '../css/admin/billing/invoice.css';
import '../css/admin/customer/show.css';
import '../css/admin/admin.css';




import '../css/components/footer.css';

/* ========= Customer show — precios y período ========= */
window.togglePeriod = function() {
    const cycle     = document.getElementById('billing_cycle');
    const periodRow = document.getElementById('period-row');
    const input     = document.getElementById('billing_month');

    if (!cycle || !periodRow || !input) return;

    if (cycle.value === 'monthly') {
        periodRow.style.display = 'flex';
        input.disabled = false;
    } else {
        periodRow.style.display = 'none';
        input.disabled = true;
    }
};

window.calcularPrecio = function() {
    const serviceId    = document.getElementById('service_id');
    const region       = document.getElementById('region');
    const clientType   = document.getElementById('client_type');
    const billingCycle = document.getElementById('billing_cycle');

    if (!serviceId || !region || !clientType || !billingCycle) return;

    const key   = `${serviceId.value}_${region.value}_${clientType.value}_${billingCycle.value}`;
    const entry = window.preciosData?.[key];

    const sugerido       = document.getElementById('precio-sugerido');
    const amount         = document.getElementById('amount');
    const servicePriceId = document.getElementById('service_price_id');

    if (entry) {
        sugerido.textContent = `$ ${parseFloat(entry.price).toFixed(2)} USD`;
        amount.value         = parseFloat(entry.price).toFixed(2);
        servicePriceId.value = entry.id;
    } else {
        sugerido.textContent = '— No price configured —';
        amount.value         = '';
        servicePriceId.value = '';
    }
};

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('billing_cycle')) {
        window.calcularPrecio();
        window.togglePeriod();
    }
});