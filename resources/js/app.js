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

/* ========= Estilos globales ========= */
import '../css/app.css';

/* ========= navegacion ========= */
import '../css/components/navbar.css';

/* ========= page ========= */
import '../css/pages/start.css';
import '../css/pages/services/web-design.css';

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




/* ========= Pages ========= */
import './admin/prospects/close.js';
import './pages/start.js';
import './pages/services/web-design.js';








