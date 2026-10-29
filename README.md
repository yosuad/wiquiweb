<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
  <a href="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
</p>

---

# 📋 Sistema CRM y Facturación — Wiquiweb

Sistema desarrollado con **Laravel 12** para administrar prospectos, clientes, servicios, facturación y el blog del sitio. Incluye automatizaciones con n8n, control de roles, captación de leads desde campañas de Meta y notificaciones automáticas.

- Gestión de prospectos y leads con pipeline de ventas
- Clientes activos con seguimiento de servicios contratados
- Facturación con recordatorios automáticos (n8n)
- Catálogo de servicios con precios por región y tipo de cliente
- Formularios públicos de leads (sitio web y campañas de Meta) con teléfono internacional
- Blog público administrable desde el panel
- Newsletter (suscripción desde el footer y el blog)
- Panel de administración con roles y permisos (Spatie)

---

## 📐 Convenciones del proyecto

| Ámbito | Idioma | Ejemplos |
|--------|--------|----------|
| Código | Inglés | Clases, modelos, tablas, columnas, variables, nombres de rutas, valores de enum, nombres de archivos |
| Interfaz | Español | Textos de vistas, botones, títulos, mensajes de validación, URLs públicas |

- CSS con metodología **BEM**. Sin Tailwind.
- Sin estilos ni JavaScript inline.
- Assets locales vía npm + Vite. Sin CDN.
- Todo el código bien comentado (cabecera de archivo + secciones).
- Separación de responsabilidades: la lógica de autorización no vive en las vistas ni en los modelos; las consultas no van en las vistas.
- **El CSS y el JS reflejan la ruta de la vista:**

| Vista | CSS | JS |
|-------|-----|----|
| `views/admin/blog/categories/index.blade.php` | `css/admin/blog/categories/index.css` | `js/admin/blog/categories/index.js` |
| `views/admin/prospects/edit.blade.php` | — | `js/admin/prospects/edit.js` |
| `views/site/blog/index.blade.php` | `css/site/blog/index.css` | — |

- Lo compartido por varios módulos va en `base/` (admin) o `components/` (global).

---

## 🗂️ Estructura del proyecto

### Controladores
```
app/Http/Controllers/
├── Controller.php          ← clase base
├── ProfileController.php   ← Breeze
├── Auth/                   ← Breeze
├── Admin/                  ← panel interno
│   ├── AdminController, BillingController, ContactController,
│   ├── ContactNoteController, DashboardController, ServiceController,
│   ├── SubscriberController, SupportController,
│   └── BlogPostController, BlogCategoryController
└── Site/                   ← sitio público
    ├── PageController          (páginas + blog público)
    ├── LeadController          (formularios de leads: web y Meta)
    └── SubscriptionController  (suscribirse / cancelar newsletter)
```

### Vistas
```
resources/views/
├── admin/        ← panel (cada módulo en su carpeta: billing/, blog/, customers/,
│                    prospects/, services/, subscribers/, support/, users/ + dashboard)
├── site/         ← sitio público (start, about, contact, privacy-policy,
│                    unsubscribe, blog/, portfolio/, services/)
├── leads/        ← formulario de campañas de Meta (página independiente)
├── components/   ← navbar, footer, sidebar, phone-input, contact-history…
├── errors/       ← layout común + 403, 404, 419, 429, 500, 503
├── vendor/pagination/
│   ├── admin.blade.php   ← paginación por defecto (todo el panel)
│   └── blog.blade.php    ← paginación del blog público
└── auth/, layouts/, profile/
```

> Cada módulo del panel usa `index.blade.php` para su listado principal y nombres descriptivos para las demás páginas (`create`, `edit`, `lost`, `close`…).

### Componentes reutilizables

| Componente | Uso | Archivos |
|------------|-----|----------|
| `<x-phone-input>` | Teléfono internacional con bandera y selector de país | `components/phone-input.blade.php`, `js/components/phone-input.js`, `css/components/phone-input.css` |
| `<x-contact-history>` | Historial de un contacto (editar prospecto / cliente) | `components/contact-history.blade.php`, `css/admin/base/contact-history.css` |
| Newsletter | Suscripción AJAX en cualquier formulario con `data-newsletter="prefijo-bem"` | `js/components/newsletter.js` |
| Paginación | `{{ $items->links() }}` (panel) / `links('vendor.pagination.blog')` (blog) | `views/vendor/pagination/` |

---

## 🔐 Autenticación, Roles y Autorización

### Laravel Breeze
Starter kit oficial para autenticación. Incluye registro, login, recuperación de contraseña y panel básico de usuario.

### Roles (Spatie Laravel Permission)
Los roles se crean en `database/seeders/UserSeeder.php`.

| Rol | Descripción |
|-----|-------------|
| `administrator` | Control total del sistema |
| `agent` | Supervisor — recluta y gestiona sales-agents |
| `sales-agent` | Vende, crea prospectos y cierra ventas. Solo ve los prospectos asignados a él |
| `billing-agent` | Gestiona facturas y pagos |
| `support` | Atiende clientes activos e implementaciones |

### Arquitectura de autorización

| Pieza | Responsabilidad | Dónde se define |
|-------|-----------------|-----------------|
| **Spatie** | Guarda roles, permisos y qué usuario tiene cada uno | Seeders |
| **Policies** | Reglas por registro (ej: "¿este prospecto es suyo?") | `app/Policies/` |
| **Laravel (`can`)** | Única puerta de entrada que consulta Spatie y Policies | Rutas, controladores, vistas |

**Reglas:**
1. Los nombres de roles solo aparecen en los seeders. En código se verifican **permisos**, no roles.
2. Un módulo necesita Policy solo si la decisión depende del registro, no solo del usuario.
3. No se crean Policies vacías por coherencia aparente.

---

## 🌍 Idioma y traducciones

- `APP_LOCALE=es` y `APP_FALLBACK_LOCALE=es` en el `.env`.
- Traducciones en `lang/es/`: `validation.php`, `auth.php`, `passwords.php`.
- Los mensajes **específicos** van en el controlador (tienen prioridad); los **genéricos** los da `lang/es/validation.php`.
- Fechas en español: `$fecha->locale('es')->translatedFormat(...)`.

---

## 📞 Teléfonos internacionales

Los leads llegan de todo el mundo (~70% Colombia; campañas en EE. UU., México, Costa Rica, Panamá, Australia y España).

| Capa | Herramienta | Qué hace |
|------|-------------|----------|
| Formulario | `intl-tel-input` v29 (npm) vía `<x-phone-input>` | Bandera + selector de país. El cliente escribe solo su número (`3205693258`) |
| Servidor | `propaganistas/laravel-phone` (libphonenumber de Google) | Regla `phone:INTERNATIONAL`: valida que el número sea real para su país |
| Base de datos | Formato **E.164**: `+573205693258` | Un solo formato para todos los países → `unique` confiable |
| Pantalla | `$contact->whatsapp_formatted` / `$contact->whatsapp_link` | `+57 320 5693258` / `https://wa.me/573205693258` |

**País inicial del campo** (en este orden): `?pais=mx` en la URL → país del visitante según Cloudflare (`CF-IPCountry`) → Colombia.

**Normalización:** `Contact::normalizePhone()` se usa en los controladores **antes de validar** y en los mutadores al guardar. Un número sin `+` se asume colombiano.

---

## 📣 Leads desde campañas de Meta

### Enlace del formulario
Todas las campañas usan **el mismo formulario**: `https://wiquiweb.co/form`
Cada anuncio le agrega parámetros que dicen de qué campaña viene.

### Parámetros

| Parámetro | Dónde se pone en Meta | Valores | Se guarda en |
|-----------|----------------------|---------|--------------|
| `servicio` | En el **sitio web** del anuncio | ver tabla de servicios | `contacts.service_interest` |
| `pais` | En el **sitio web** del anuncio | código de 2 letras: `co`, `us`, `mx`, `cr`, `pa`, `au`, `es` | (solo el país inicial del WhatsApp) |
| `utm_campaign` | En **Parámetros de URL** | `{{campaign.name}}` (Meta lo llena solo) | `contacts.campaign` |
| `utm_content` | En **Parámetros de URL** | `{{ad.name}}` (Meta lo llena solo) | `contacts.ad` |

**Servicios válidos para `?servicio=`** (si llega otro, se usa `pagina_web`):

| Valor | Servicio |
|-------|----------|
| `pagina_web` | Página web (por defecto) |
| `landing_page` | Landing page |
| `asistente_virtual` | Asistente virtual |
| `crm` | CRM |
| `erp` | ERP |
| `campana_publicitaria` | Campaña publicitaria |
| `diseno` | Diseño |

### Cómo configurar un anuncio

**1. Sitio web del anuncio** (cambia según servicio y país):
```
https://wiquiweb.co/form?servicio=landing_page&pais=mx
```

**2. Parámetros de URL** (el **mismo texto en todos los anuncios**; se copia al duplicar un anuncio):
```
utm_campaign={{campaign.name}}&utm_content={{ad.name}}
```

### Enlaces listos por país (servicio: página web)

| País | Sitio web del anuncio |
|------|-----------------------|
| 🇨🇴 Colombia | `https://wiquiweb.co/form?servicio=pagina_web&pais=co` |
| 🇺🇸 Estados Unidos | `https://wiquiweb.co/form?servicio=pagina_web&pais=us` |
| 🇲🇽 México | `https://wiquiweb.co/form?servicio=pagina_web&pais=mx` |
| 🇨🇷 Costa Rica | `https://wiquiweb.co/form?servicio=pagina_web&pais=cr` |
| 🇵🇦 Panamá | `https://wiquiweb.co/form?servicio=pagina_web&pais=pa` |
| 🇦🇺 Australia | `https://wiquiweb.co/form?servicio=pagina_web&pais=au` |
| 🇪🇸 España | `https://wiquiweb.co/form?servicio=pagina_web&pais=es` |

> Para otro servicio, cambia solo `servicio=`: ej. `?servicio=landing_page&pais=mx`.

### Nombres de campañas y anuncios
**Los nombres que pongas en Meta son los que verás en el CRM.** Usa una convención clara:
- Campaña: `Servicio-País-MesAño` → `Landing-MX-Nov2026`
- Anuncio: `Formato-Enfoque` → `Video-testimonio`, `Imagen-precio`, `Carrusel-portafolio`

### Meta Pixel
- Código base en el `<head>` de `views/leads/form.blade.php` (evento `PageView`).
- Evento `Lead` en `js/leads/form.js`, **solo** cuando el envío es exitoso.

### Prueba rápida
```
/form?servicio=landing_page&pais=mx&utm_campaign=Landing-MX-Nov&utm_content=Video-testimonio
```

---

## 🔁 Leads que vuelven

Si alguien llena un formulario público con un **WhatsApp o correo que ya existe**, **no se crea un duplicado**:

| Estado del contacto | Qué hace el sistema |
|---------------------|---------------------|
| Perdido (`lost`) | Lo reactiva como Prospecto / Nuevo |
| Prospecto | Lo deja igual |
| Cliente | No cambia su estado |

**En todos los casos** queda en el historial (`contact_logs`):
- `returned` → *"Volvió a escribir por el Formulario Meta · Landing-MX-Nov · Imagen-precio"*
- `whatsapp_mismatch` → si escribió otro WhatsApp (se muestran los dos; el equipo decide)
- `email_mismatch` → si escribió otro correo

La **campaña y el anuncio originales no se cambian** (primer contacto). El visitante siempre ve el mismo "¡Gracias!".

---

## 🔄 Flujo de Ventas
```
Prospecto nuevo (pipeline_stage: new)
        ↓
Agente contacta → edita datos en prospects/edit
        ↓
Agente cambia status a "customer" → pipeline_stage: closing
   (todos los datos pasan a ser obligatorios: apellido, empresa, origen,
    tipo de cliente, servicio y agente)
        ↓
Agente completa close sale → genera factura (pipeline_stage: pending_payment)
        ↓
Cliente paga → Agente marca factura como "paid"
        ↓
Administrator valida que el dinero llegó → Aprueba factura
        ↓
Contacto se convierte en "customer" → pasa a vista Customers
        ↓
Soporte recibe el cliente para implementación
```

---

## 📊 Pipeline de Prospectos

| pipeline_stage | Descripción |
|----------------|-------------|
| `new` | Prospecto recién registrado |
| `closing` | En proceso de cierre — factura pendiente de generar |
| `pending_payment` | Factura generada — esperando pago del cliente |

| status | Descripción |
|--------|-------------|
| `prospect` | Lead activo en el pipeline |
| `customer` | Cliente con servicio aprobado |
| `lost` | No calificó o no cerró |

> Cuando un prospecto se marca como `lost`, sus servicios activos se cancelan y sus facturas pendientes se anulan automáticamente.

---

## 🖥️ Páginas del Panel

Solo accesibles para usuarios autenticados, verificados y aprobados (`auth`, `verified`, `approved`).

| Ruta | Descripción |
|------|-------------|
| `/dashboard` | Panel general de control |
| `/prospects` | Prospectos activos |
| `/prospects/lost` | Prospectos perdidos — se pueden reactivar |
| `/customers` | Clientes activos con servicios contratados |
| `/billing` | Facturas, pagos y aprobaciones |
| `/support` | Tickets de soporte |
| `/services` | Catálogo de servicios y precios |
| `/subscribers` | Suscriptores del newsletter |
| `/admin/blog` | Artículos del blog |
| `/admin/blog/categories` | Categorías del blog |
| `/admin` | Usuarios internos y privilegios |

## 🌐 Páginas públicas

| Ruta | Nombre de ruta | Descripción |
|------|----------------|-------------|
| `/` | `home` | Inicio |
| `/nosotros` | `about` | Nosotros |
| `/servicios/...` | `services.*` | Páginas de servicios |
| `/portafolio` | `portfolio` | Portafolio |
| `/blog` | `blog` | Listado (filtro: `?categoria=slug`) |
| `/blog/{slug}` | `blog.post` | Artículo |
| `/contacto` | `contact` | Contacto |
| `/form` | `form` | Formulario de campañas de Meta |
| `/privacy_policy` | `privacy` | Política de privacidad |
| `/suscribirse` (POST) | `subscribers.store` | Newsletter |
| `/unsubscribe` | `subscribers.unsubscribe.page` | Cancelar suscripción |

---

## 📰 Módulo Blog

### Componentes

| Tipo | Archivo |
|------|---------|
| Modelos | `BlogPost`, `BlogCategory`, `BlogTag` |
| Controladores admin | `Admin/BlogPostController`, `Admin/BlogCategoryController` |
| Controlador público | `Site/PageController` (`blog`, `blogPost`) |
| Vistas admin | `admin/blog/index`, `create`, `edit`, `_form`, `categories/index` |
| JS admin | `js/admin/blog/form.js` (Quill + etiquetas), `js/admin/blog/categories/index.js` (editar nombre) |
| CSS admin | `css/admin/base/list-page.css` (listado), `css/admin/blog/form.css`, `css/admin/blog/categories/index.css` |
| Editor de contenido | Quill (npm), importado solo en `js/admin/blog/form.js` |
| Permisos (Spatie) | `view blog`, `create blog`, `edit blog`, `delete blog` |

### Reglas de negocio
- **Artículo principal:** solo uno (`is_featured`). Al marcar uno, el anterior se desmarca automáticamente. Se muestra como banner en `/blog`.
- **Estados:** `draft` (Borrador) / `published` (Publicada).
- **Fecha de publicación:** se asigna al publicar, salvo que se escriba una.
- **Categoría predeterminada:** la primera creada. No se puede eliminar; al borrar otra, sus artículos pasan a la predeterminada.
- **Slug:** si no se escribe, se genera del título y se garantiza único.
- **Vistas "conscientes":** una vista por visitante por artículo cada 24 h (IP + navegador cifrados en caché); no cuentan usuarios logueados ni robots.
- **Imágenes:** disco `uploads`, carpetas `blog/featured`, `blog/thumbnails` y `blog/content`.

---

## 🗄️ Estructura de Base de Datos

### `users`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| last_name | VARCHAR | Apellido (nullable) |
| email | VARCHAR | Email único |
| password | VARCHAR | Contraseña |
| status | ENUM | `pending` / `approved` / `rejected` |
| whatsapp | VARCHAR | WhatsApp (nullable) |
| phone | VARCHAR | Teléfono (nullable) |

> Todo usuario nuevo queda en `pending` hasta ser aprobado manualmente.

### `services`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR(150) | Nombre del servicio |
| slug | VARCHAR(150) | Identificador único |
| description | TEXT | Descripción opcional |

### `service_prices`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| service_id | BIGINT | FK → services.id |
| region | ENUM | `colombia` / `international` |
| client_type | ENUM | `persona_natural` / `empresa` / `emprendimiento` / `artista` / `organizacion_social` |
| type | ENUM | `recurring` / `one_time` / `mixed` |
| billing_cycle | ENUM | `monthly` / `annual` / `one_time` |
| plan | VARCHAR(150) | Nombre del plan (nullable) |
| price | DECIMAL(10,2) | Precio |
| currency | CHAR(3) | `USD` por defecto |

> Unique constraint sobre `(service_id, region, client_type, billing_cycle, plan)`.

### `contacts`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| first_name | VARCHAR | Nombre |
| last_name | VARCHAR | Apellido (nullable; obligatorio al pasar a cliente) |
| email | VARCHAR | **Obligatorio y único** (respaldo si el WhatsApp viene mal) |
| whatsapp | VARCHAR(20) | **Obligatorio y único**, formato E.164 (`+573205693258`) |
| phone | VARCHAR(20) | Teléfono, formato E.164 (nullable) |
| company_name | VARCHAR | Empresa (nullable; obligatoria al pasar a cliente) |
| address | VARCHAR | Dirección de facturación (nullable) |
| document_type | ENUM | `national_id` / `tax_id` / `rut` / `foreign_id` / `passport` / `ein` (nullable) |
| document_number | VARCHAR(30) | Número de documento (nullable) |
| region | ENUM | `colombia` / `international` (nullable) |
| client_type | ENUM | `persona_natural` / `empresa` / `emprendimiento` / `artista` / `organizacion_social` (nullable) |
| origin | ENUM | `facebook` / `instagram` / `referido` / `web` / `agente` / `meta` (nullable) |
| campaign | VARCHAR | Campaña de Meta que lo trajo (`utm_campaign`) (nullable) |
| ad | VARCHAR | Anuncio de Meta que lo trajo (`utm_content`) (nullable) |
| service_interest | VARCHAR | Servicio de interés (nullable) |
| assigned_to | BIGINT | FK → users.id (nullable) |
| status | ENUM | `prospect` / `customer` / `lost` |
| pipeline_stage | ENUM | `new` / `closing` / `pending_payment` |
| is_active | BOOLEAN | Activo por defecto |
| privacy_accepted_at | TIMESTAMP | Aceptación de la política (Ley 1581) (nullable) |

### `contact_services`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| service_id | BIGINT | FK → services.id |
| description | VARCHAR | Diferencia instancias del mismo servicio (ej: dominio) (nullable) |
| service_price_id | BIGINT | FK → service_prices.id |
| price | DECIMAL(10,2) | Precio congelado al momento del contrato |
| currency | CHAR(3) | `USD` por defecto |
| billing_cycle | ENUM | `monthly` / `annual` / `one_time` |
| status | ENUM | `active` / `suspended` / `cancelled` |
| started_at | DATE | Fecha de inicio (nullable) |
| ends_at | DATE | Fecha de fin (nullable) |

### `invoices`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_service_id | BIGINT | FK → contact_services.id |
| amount | DECIMAL(10,2) | Monto congelado al momento de facturar |
| period_start | DATE | Inicio del período (nullable) |
| period_end | DATE | Fin del período (nullable) |
| payment_link | VARCHAR | Enlace de pago (nullable) |
| status | ENUM | `pending` / `paid` / `approved` / `courtesy` / `cancelled` |
| created_by | BIGINT | FK → users.id |
| paid_at | TIMESTAMP | Fecha de pago (nullable) |
| approved_at | TIMESTAMP | Fecha de aprobación (nullable) |

### `invoice_reminders`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| invoice_id | BIGINT | FK → invoices.id |
| reminder_number | TINYINT | 1 = 15 días mora / 2 = 30 días mora |
| sent_at | TIMESTAMP | Fecha y hora de envío |
| status | ENUM | `sent` / `failed` |

### `contact_notes`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id |
| note | TEXT | Contenido de la nota |

### `contact_logs`
Historial por contacto (se muestra con `<x-contact-history>`).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id (null = Sistema) |
| type | VARCHAR | `status_change` / `assignment_change` / `returned` / `whatsapp_mismatch` / `email_mismatch` |
| from | VARCHAR | Valor anterior (nullable) |
| to | VARCHAR | Valor nuevo (nullable) |

### `support_tickets`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id |
| assigned_to | BIGINT | FK → users.id (nullable) |
| subject | VARCHAR | Asunto |
| description | TEXT | Descripción (nullable) |
| status | ENUM | `open` / `in_progress` / `resolved` / `closed` |
| priority | ENUM | `low` / `medium` / `high` |
| resolved_at | TIMESTAMP | Fecha de resolución (nullable) |

### `support_ticket_notes`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| ticket_id | BIGINT | FK → support_tickets.id |
| created_by | BIGINT | FK → users.id |
| note | TEXT | Contenido de la nota |

### `blog_categories`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| slug | VARCHAR | Identificador único (filtro `?categoria=`) |
| is_default | BOOLEAN | Categoría predeterminada (solo una) |

### `blog_tags`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| slug | VARCHAR | Identificador único |

### `blog_posts`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| title | VARCHAR | Título |
| slug | VARCHAR | Identificador único (URL) |
| category_id | BIGINT | FK → blog_categories.id |
| featured_image | VARCHAR | Imagen destacada (nullable) |
| thumbnail_image | VARCHAR | Imagen miniatura (nullable) |
| excerpt | TEXT | Extracto (nullable) |
| content | LONGTEXT | Contenido HTML (Quill) |
| status | ENUM | `draft` / `published` |
| is_featured | BOOLEAN | Artículo principal (solo uno) |
| author_id | BIGINT | FK → users.id |
| views | INT | Vistas "conscientes" |
| published_at | TIMESTAMP | Fecha de publicación (nullable) |

> Índice compuesto sobre `(status, published_at)` para el listado público.

### `blog_post_tag`
| Campo | Tipo | Descripción |
|-------|------|-------------|
| post_id | BIGINT | FK → blog_posts.id |
| tag_id | BIGINT | FK → blog_tags.id |

> PK compuesta `(post_id, tag_id)`.

---

## 🔄 Flujo de Relaciones
```
users (agentes/administradores)
  ↓ assigned_to / created_by / author_id
contacts (prospectos/clientes)
  ↓
contact_services ← services → service_prices
  ↓
invoices → invoice_reminders (n8n)

contacts
  ↓
contact_notes
contact_logs
support_tickets → support_ticket_notes

blog_categories
  ↓
blog_posts ←→ blog_post_tag ←→ blog_tags
```

---

## ⚠️ Páginas de error

Diseño común en `views/errors/layout.blade.php` (CSS: `css/errors/layout.css`). Páginas: **403, 404, 419, 429, 500, 503**. Cada una solo define código, título, mensaje y botón.

---

## ✅ Estado del Proyecto

- [x] Autenticación con Laravel Breeze
- [x] Roles con Spatie Laravel Permission
- [x] Íconos con Lucide (FontAwesome eliminado)
- [x] Controladores organizados en `Admin/` y `Site/`
- [x] Vistas del panel unificadas en `carpeta/index`
- [x] Pipeline de prospectos y flujo de facturación
- [x] Historial por contacto (componente reutilizable)
- [x] Blog: admin completo (listado, formulario, categorías) y listado público
- [x] Newsletter reutilizable (footer y blog)
- [x] Páginas de error propias
- [x] Traducciones al español (`lang/es`)
- [x] Teléfonos internacionales (E.164, bandera, validación por país)
- [x] WhatsApp y correo únicos (sin duplicados)
- [x] Leads que vuelven (reactivación + historial)
- [x] Campañas de Meta: servicio, campaña y anuncio por enlace
- [ ] customers/show — detalle de cliente con servicios
- [ ] Notificaciones automáticas con n8n

---

## 📌 Pendientes

### 🔴 En curso: teléfono internacional y leads
- [ ] Editar cliente: fila de campaña y anuncio (solo lectura)
- [ ] Página de contacto (`site/contact.blade.php` + `contact.js`): bandera, correo obligatorio, errores
- [ ] Sección de contacto del inicio (`site/start.blade.php`): bandera; su JS hoy no muestra errores al visitante
- [ ] `storeContact`: validar casilla de privacidad (si existe) y guardar la fecha
- [ ] Listados del panel: mostrar `whatsapp_formatted` y enlace `wa.me`

### 🟠 Blog
- [ ] Artículo público (`site/blog/show.blade.php`): conectar a datos reales (hoy es maqueta)
- [ ] Newsletter del blog: CSS de éxito y error (`blog-newsletter__success`, `__error`, `__form--done`)
- [ ] Revisar `PermissionSeeder` (permisos del blog)

### 🟡 Orden y consistencia del código
- [ ] Textos del panel a español (vistas pendientes y mensajes de éxito de los controladores)
- [ ] Soporte al diseño nuevo de listados (`list-page.css`) y quitar sus estilos inline
- [ ] Convertir todo el panel a BEM
- [ ] Rutas del panel bajo prefijo `/admin`
- [ ] `role:administrator` → permisos (rutas de Servicios/Suscriptores y sidebar)
- [ ] URLs públicas en español (`/privacy_policy`, `/unsubscribe`) con redirección 301
- [ ] Footer: `url('nosotros')` → `route('about')`
- [ ] `PageController`: `start()` y `about()` duplicados, variables en español
- [ ] `landing.css` se carga dos veces
- [ ] Columna `password` en `contacts`: parece innecesaria
- [ ] Origen del newsletter guardado como `wiquiweb.com` (dominio real `.co`)
- [ ] Tailwind sigue activo (vistas de login de Breeze)
- [ ] Retoques de CSS en facturación y soporte

### 🔵 Seguridad y permisos
- [ ] `ContactPolicy`: `close` y `generateInvoice` no verifican que el prospecto sea del agente
- [ ] `/unsubscribe` sin enlace firmado (cualquiera puede dar de baja a otro correo)
- [ ] `/register` abierto al público: decidir si se cierra
- [ ] Quitar `guest` de `/` y `/form` + aviso "Estás logueado · Ir al panel"

### 🟣 Funcionalidades nuevas
- [ ] **Pipeline de seguimiento:** Nuevo → Contactado (hasta 3 intentos) → No asistió → Reunión → Propuesta → Cierre → Pendiente de pago (hasta 3 recordatorios) → Cliente / Perdido
- [ ] **Reporte de campañas:** leads y cierres por campaña y anuncio
- [ ] Correo de confirmación automático al lead (n8n)
- [ ] Aviso cuando un lead perdido regresa

### ⚫ Antes de subir a producción
- [ ] `.env` del servidor: `APP_DEBUG=false`, `APP_LOCALE=es`, `APP_FALLBACK_LOCALE=es`
- [ ] Contraseña del admin: sacarla de `UserSeeder` al `.env` y cambiarla si ya se subió al repositorio
- [ ] `composer audit` (47 avisos) y `npm audit` (16)
- [ ] Renombrar `database/seeders/Settingseeder.php` → `SettingSeeder.php`
- [ ] Migraciones editadas (contactos y blog): si las tablas ya existen en producción, el cambio no llegará
- [ ] Commit en git

### ✅ Pruebas finales
- [ ] Cierre de venta: prospecto → factura → cliente
- [ ] Formularios públicos: contacto, inicio, Meta, suscribirse y cancelar suscripción
- [ ] Páginas públicas y navbar (escritorio y celular)
- [ ] Páginas de error (404, 419…)
- [ ] Documentar las tablas `subscribers` y `settings` en este README