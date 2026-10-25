/* ========= Carga AlpineJS y lo inicializa ========= */
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

/* ========= SweetAlert2 ========= */
import Swal from 'sweetalert2';
window.Swal = Swal;

/* ========= SweetAlert2 — alertas desde sesión Laravel ========= */
import './alerts.js';

/* ========= Lucide icons ========= */
import { createIcons, icons } from 'lucide';
document.addEventListener('DOMContentLoaded', () => createIcons({ icons }));

/* ========= Quill editor ========= */
import Quill from 'quill';
import 'quill/dist/quill.snow.css';
window.Quill = Quill;

/* ========= Estilos globales ========= */
import '../css/app.css';

/* ========= navegacion ========= */
import '../css/components/navbar.css';

/* ========= page ========= */
import '../css/site/start.css';
import '../css/site/about.css';
import '../css/site/contact.css';
import '../css/site/services/web-design.css';
import '../css/site/privacy-policy.css';
import '../css/site/services/landing.css';
import '../css/site/portfolio/index.css';  // ← está en portfolio/index.css
import '../css/site/blog/index.css';
import '../css/site/blog/show.css';

import '../css/errors/404.css';

/* ========= Componentes ========= */
import '../css/components/navigation.css';
import '../css/components/sidebar.css';
import '../css/admin/dashboard.css';
import '../css/admin/tables.css';
import '../css/admin/create.css';
import '../css/admin/billing/invoice.css';
import '../css/admin/customer/show.css';
import '../css/admin/admin.css';
import '../css/admin/subscribers.css';
import '../css/components/footer.css';
import '../css/site/unsubscribe.css';

/* ========= Pages ========= */
import './admin/prospects/close.js';
import './site/start.js';
import './site/contact.js';
import './site/services/web-design.js';