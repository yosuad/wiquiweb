/************************************************************************************/
/*                 ADMIN PROSPECTOS CLOSE- PERMITIR CARGAR LOS PRECIOS             */
/*********************************************************************************/

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
    const amountInput    = document.getElementById('amount');
    const servicePriceId = document.getElementById('service_price_id');
    const amountLabel    = document.getElementById('amount-label');

    if (entry) {
        const isCOP  = entry.currency === 'COP';
        const precio = parseFloat(entry.price);

        sugerido.textContent = isCOP
            ? `$ ${precio.toLocaleString('es-CO', { maximumFractionDigits: 0 })} COP`
            : `$ ${precio.toFixed(2)} USD`;

        amountInput.value    = precio.toFixed(2);
        servicePriceId.value = entry.id;

        if (amountLabel) {
            amountLabel.innerHTML = isCOP
                ? 'Final price COP <span class="required">*</span>'
                : 'Final price USD <span class="required">*</span>';
        }
    } else {
        sugerido.textContent = '— No price configured —';
        amountInput.value    = '';
        servicePriceId.value = '';

        if (amountLabel) {
            amountLabel.innerHTML = 'Final price <span class="required">*</span>';
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('billing_cycle')) {
        window.calcularPrecio();
        window.togglePeriod();
    }
});