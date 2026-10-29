/* ==========================================================
   LIBRERÍAS
   ========================================================== */

/* ========= AlpineJS ========= */
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/* ========= SweetAlert2 ========= */
import Swal from 'sweetalert2';
window.Swal = Swal;

/* ========= SweetAlert2 — alertas desde sesión Laravel ========= */
import './alerts.js';

/* ========= Newsletter — suscripción AJAX (footer y blog) ========= */
import './components/newsletter.js';

/* ========= Formularios de contacto — AJAX (página de contacto e inicio) ========= */
import './components/lead-form.js';

/* ========= Teléfono internacional (solo si la página tiene un campo) ========= */
if (document.querySelector('input[data-phone-input]')) {
    import('./components/phone-input.js');
}

/* ========= Lucide icons ========= */
import { createIcons, icons } from 'lucide';
document.addEventListener('DOMContentLoaded', () => createIcons({ icons }));

/* (Quill se carga solo en el formulario del blog: js/admin/blog/form.js) */


/* ==========================================================
   CSS
   ========================================================== */

/* ========= Global ========= */
import '../css/app.css';

/* ========= Componentes ========= */
import '../css/components/navbar.css';
import '../css/components/navigation.css';
import '../css/components/sidebar.css';
import '../css/components/footer.css';

/* ========= Sitio público ========= */
import '../css/site/start.css';
import '../css/site/about.css';
import '../css/site/services/web-design.css';
import '../css/site/services/landing.css';
import '../css/site/portfolio/index.css';
import '../css/site/blog/index.css';
import '../css/site/blog/show.css';
import '../css/site/contact.css';
import '../css/site/privacy-policy.css';
import '../css/site/unsubscribe.css';

/* ========= Errores ========= */
import '../css/errors/layout.css';

/* ========= Admin: base (compartido) ========= */
import '../css/admin/base/tables.css';
import '../css/admin/base/forms.css';
import '../css/admin/base/list-page.css';
import '../css/admin/base/contact-history.css';

/* ========= Admin: módulos ========= */
import '../css/admin/dashboard/index.css';
import '../css/admin/billing/invoice.css';
import '../css/admin/customers/show.css';
import '../css/admin/subscribers/index.css';
import '../css/admin/users/index.css';

/* ========= Admin: blog ========= */
import '../css/admin/blog/form.css';
import '../css/admin/blog/categories/index.css';


/* ==========================================================
   JS DE PÁGINAS
   ========================================================== */

/* ========= Sitio público ========= */
import './site/start.js';
import './site/services/web-design.js';

/* ========= Admin ========= */
import './admin/prospects/close.js';