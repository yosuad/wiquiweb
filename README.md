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

Sistema desarrollado con **Laravel 12** para administrar prospectos, clientes, servicios, facturación y el blog del sitio. Incluye automatizaciones con n8n, control de roles y notificaciones automáticas.

- Gestión de prospectos y leads con pipeline de ventas
- Clientes activos con seguimiento de servicios contratados
- Facturación con recordatorios automáticos (n8n)
- Catálogo de servicios con precios por región y tipo de cliente
- Blog público administrable desde el panel
- Panel de administración con roles y permisos (Spatie)

---

## 📐 Convenciones del proyecto

| Ámbito | Idioma | Ejemplos |
|--------|--------|----------|
| Código | Inglés | Clases, modelos, tablas, columnas, variables, nombres de rutas, valores de enum |
| Interfaz | Español | Textos de vistas, botones, títulos, mensajes de validación |

- CSS con metodología **BEM**. Sin Tailwind.
- Sin estilos ni JavaScript inline.
- Assets locales vía npm + Vite. Sin CDN.
- Separación de responsabilidades: la lógica de autorización no vive en las vistas ni en los modelos.

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
| **Policies** | Reglas por registro (ej: "¿este post es suyo?") | `app/Policies/` |
| **Laravel (`can`)** | Única puerta de entrada que consulta Spatie y Policies | Rutas, controladores, vistas |

**Reglas:**
1. Los nombres de roles solo aparecen en los seeders. En código se verifican **permisos**, no roles.
2. Un módulo necesita Policy solo si la decisión depende del registro, no solo del usuario.
   - "Solo quien tenga `view billing` entra a facturación" → permiso en la ruta.
   - "Un redactor solo edita sus propios posts" → Policy.
3. No se crean Policies vacías por coherencia aparente.

---

## 🎨 Íconos — Lucide Icons

El sitio usa **Lucide Icons** como librería de íconos de interfaz.

**Uso en blade:**
```html
<i data-lucide="globe"></i>
<i data-lucide="mail"></i>
<i data-lucide="arrow-right"></i>
```

Lucide convierte automáticamente los atributos `data-lucide` en SVGs inline al cargar la página.

**Íconos de redes sociales** — como Lucide no incluye íconos de marcas (Facebook, Instagram, etc.), se usan **SVGs inline** directamente en el blade, sin dependencia externa.

> **FontAwesome fue eliminado del proyecto.**

---

## 🔄 Flujo de Ventas
```
Prospecto nuevo (pipeline_stage: new)
        ↓
Agente contacta → edita datos en prospects/edit
        ↓
Agente cambia status a "customer" → pipeline_stage: closing
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

**Roles involucrados en el flujo:**
- `sales-agent` → cierra la venta y marca cuando el cliente paga
- `administrator` → valida el pago y aprueba la factura
- `support` → recibe el cliente para implementación

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

Solo accesibles para usuarios autenticados y verificados (`auth`, `verified`).

| Ruta | Nombre | Descripción |
|------|--------|-------------|
| `/dashboard` | Dashboard | Panel general de control |
| `/prospects` | Prospectos | Leads activos con pipeline de ventas |
| `/prospects/lost` | No calificaron | Prospectos perdidos — se pueden reactivar |
| `/customers` | Clientes | Clientes activos con servicios contratados |
| `/billing` | Facturación | Facturas, pagos y aprobaciones |
| `/services` | Servicios | Catálogo de servicios y precios |
| `/admin` | Administración | Usuarios internos y privilegios |
| `/admin/blog` | Blog | Artículos, categorías y etiquetas |

## 🌐 Páginas públicas

| Ruta | Nombre de ruta | Descripción |
|------|----------------|-------------|
| `/blog` | `blog` | Listado de artículos publicados |
| `/blog/{slug}` | `blog.post` | Detalle de un artículo |

---

## 📄 Vistas

### Prospectos (`/prospects`)
Gestión de leads desde su primer contacto. El equipo registra el prospecto y completa los datos tras la llamada.

| Campo | Descripción |
|-------|-------------|
| Nombre | Nombre del prospecto |
| WhatsApp | Contacto principal |
| Origen | Facebook / Instagram / Referido / Web / Agente / Meta |
| Tipo / Interés | Tipo de cliente y servicio de interés |
| Estado | Badge de pipeline (Prospect / Closing / Pending payment) |
| Asignado a | Agente responsable |
| Fecha | Fecha de registro |

### Prospectos perdidos (`/prospects/lost`)
Leads que no cerraron. Pueden ser reactivados editando su estado de vuelta a `prospect`.

### Clientes (`/customers`)
Contactos con status `customer` — tienen al menos un servicio aprobado.

| Campo | Descripción |
|-------|-------------|
| Empresa | Nombre de la empresa |
| Nombre | Contacto principal |
| WhatsApp | Teléfono de contacto |
| Email | Correo electrónico |
| Servicios | Servicios contratados activos |
| Asignado a | Agente responsable |
| Fecha | Fecha de registro |

### Facturación (`/billing`)
Seguimiento de facturas. Los recordatorios los genera n8n automáticamente.

| Estado factura | Descripción |
|----------------|-------------|
| `pending` | Factura generada, cliente no ha pagado |
| `paid` | Cliente pagó — pendiente validación del administrator |
| `approved` | Administrator validó el pago — contacto pasa a cliente |
| `courtesy` | Servicio cortesía — sin cobro |
| `cancelled` | Factura anulada |

### Servicios (`/services`)
Catálogo de servicios con precios configurables por región, tipo de cliente y ciclo de facturación.

| Campo precio | Opciones |
|-------------|----------|
| Región | Colombia / Internacional |
| Tipo de cliente | Persona natural / Empresa / Emprendimiento / Artista / Organización social |
| Ciclo | Pago mensual / Pago anual / Pago único |

---

## 📰 Módulo Blog

### Componentes

| Tipo | Archivo |
|------|---------|
| Modelos | `BlogPost`, `BlogCategory`, `BlogTag` |
| Controladores admin | `Admin/BlogPostController`, `Admin/BlogCategoryController` |
| Controlador público | `PageController` |
| Vistas admin | `admin/blog/index`, `create`, `edit`, `_form`, `categories/index` |
| Editor de contenido | Quill (npm), expuesto como `window.Quill` |
| Permisos (Spatie) | `view blog`, `create blog`, `edit blog`, `delete blog` |

### Reglas de negocio
- **Destacados:** máximo 3 posiciones (`featured_order` 1, 2 o 3). Al destacar un post en una posición ocupada, el anterior se libera automáticamente.
- **Categoría predeterminada:** la primera categoría creada queda como predeterminada. No se puede eliminar; al borrar otra categoría, sus posts se mueven a la predeterminada.
- **Slug:** si no se escribe, se genera a partir del título y se garantiza único.
- **Imágenes:** se guardan en el disco `uploads` en `blog/featured`, `blog/thumbnails` y `blog/content`.
- **Estados:** `draft` / `review` / `published` (se muestran en español en las vistas).

---

## 🗄️ Estructura de Base de Datos

### `users`
Usuarios internos del sistema (agentes, administradores, soporte).

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
Catálogo de servicios ofrecidos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR(150) | Nombre del servicio |
| slug | VARCHAR(150) | Identificador único |
| description | TEXT | Descripción opcional |

### `service_prices`
Precios por servicio, región, tipo de cliente y ciclo.

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

> Unique constraint sobre `(service_id, region, client_type, billing_cycle, plan)` para evitar precios duplicados.

### `contacts`
Prospectos y clientes del CRM.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| first_name | VARCHAR | Nombre |
| last_name | VARCHAR | Apellido (nullable) |
| email | VARCHAR | Email único (nullable) |
| whatsapp | VARCHAR | WhatsApp (nullable) |
| phone | VARCHAR | Teléfono (nullable) |
| company_name | VARCHAR | Empresa (nullable) |
| address | VARCHAR | Dirección de facturación (nullable) |
| document_type | ENUM | `national_id` / `tax_id` / `passport` (nullable) |
| document_number | VARCHAR(30) | Número de documento (nullable) |
| region | ENUM | `colombia` / `international` (nullable) |
| client_type | ENUM | `persona_natural` / `empresa` / `emprendimiento` / `artista` / `organizacion_social` (nullable) |
| origin | ENUM | `facebook` / `instagram` / `referido` / `web` / `agente` / `meta` (nullable) |
| service_interest | VARCHAR | Servicio de interés (nullable) |
| assigned_to | BIGINT | FK → users.id (nullable) |
| status | ENUM | `prospect` / `customer` / `lost` |
| pipeline_stage | ENUM | `new` / `closing` / `pending_payment` |
| is_active | BOOLEAN | Activo por defecto |
| privacy_accepted_at | TIMESTAMP | Aceptación GDPR / Ley 1581 (nullable) |

### `contact_services`
Servicios contratados por cada cliente.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| service_id | BIGINT | FK → services.id |
| description | VARCHAR | Descripción opcional — diferencia instancias del mismo servicio (ej: dominio cliente.com) (nullable) |
| service_price_id | BIGINT | FK → service_prices.id |
| price | DECIMAL(10,2) | Precio congelado al momento del contrato |
| currency | CHAR(3) | `USD` por defecto |
| billing_cycle | ENUM | `monthly` / `annual` / `one_time` |
| status | ENUM | `active` / `suspended` / `cancelled` |
| started_at | DATE | Fecha de inicio (nullable) |
| ends_at | DATE | Fecha de fin (nullable) |

> La combinación `(contact_id, service_id, description)` se usa como clave lógica para identificar instancias únicas del mismo servicio. Esto permite que un cliente tenga, por ejemplo, dos hostings con dominios distintos como servicios separados.

### `invoices`
Facturas generadas para cada servicio contratado.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_service_id | BIGINT | FK → contact_services.id |
| amount | DECIMAL(10,2) | Monto congelado al momento de facturar |
| period_start | DATE | Inicio del período facturado (nullable) |
| period_end | DATE | Fin del período facturado (nullable) |
| payment_link | VARCHAR | Enlace de pago (nullable) |
| status | ENUM | `pending` / `paid` / `approved` / `courtesy` / `cancelled` |
| created_by | BIGINT | FK → users.id |
| paid_at | TIMESTAMP | Fecha de pago (nullable) |
| approved_at | TIMESTAMP | Fecha de aprobación (nullable) |

> El campo `amount` preserva el precio original aunque el catálogo cambie — garantía de integridad contable.

### `invoice_reminders`
Recordatorios automáticos generados por n8n.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| invoice_id | BIGINT | FK → invoices.id |
| reminder_number | TINYINT | 1 = 15 días mora / 2 = 30 días mora |
| sent_at | TIMESTAMP | Fecha y hora de envío |
| status | ENUM | `sent` / `failed` |

> Unique constraint sobre `(invoice_id, reminder_number)` para evitar recordatorios duplicados.

### `contact_notes`
Notas internas de seguimiento por contacto.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id |
| note | TEXT | Contenido de la nota |

### `contact_logs`
Historial de cambios de estado y asignaciones por contacto.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id |
| type | VARCHAR | `status_change` / `assignment_change` |
| from | VARCHAR | Valor anterior (nullable) |
| to | VARCHAR | Valor nuevo (nullable) |

### `support_tickets`
Tickets de soporte asociados a clientes.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| created_by | BIGINT | FK → users.id |
| assigned_to | BIGINT | FK → users.id (nullable) |
| subject | VARCHAR | Asunto del ticket |
| description | TEXT | Descripción del problema (nullable) |
| status | ENUM | `open` / `in_progress` / `resolved` / `closed` |
| priority | ENUM | `low` / `medium` / `high` |
| resolved_at | TIMESTAMP | Fecha de resolución (nullable) |

### `support_ticket_notes`
Notas internas de seguimiento por ticket.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| ticket_id | BIGINT | FK → support_tickets.id |
| created_by | BIGINT | FK → users.id |
| note | TEXT | Contenido de la nota |

### `blog_categories`
Categorías del blog.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| slug | VARCHAR | Identificador único |
| is_default | BOOLEAN | Categoría predeterminada (solo una) |

### `blog_tags`
Etiquetas del blog.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| slug | VARCHAR | Identificador único |

### `blog_posts`
Artículos del blog.

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
| status | ENUM | `draft` / `review` / `published` |
| featured_status | ENUM | `none` / `featured` |
| featured_order | TINYINT | Posición destacada 1–3 (nullable) |
| author_id | BIGINT | FK → users.id |
| views | INT | Contador de vistas |
| published_at | TIMESTAMP | Fecha de publicación (nullable) |

> Índice compuesto sobre `(status, published_at)` para el listado público.

### `blog_post_tag`
Tabla pivote entre posts y etiquetas.

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

## ✅ Estado del Proyecto

- [x] Autenticación con Laravel Breeze
- [x] Roles con Spatie Laravel Permission
- [x] Íconos de interfaz con Lucide Icons
- [x] FontAwesome eliminado del proyecto
- [x] Migraciones y modelos
- [x] Pipeline de prospectos (new → closing → pending_payment)
- [x] Flujo de facturación (pending → paid → approved)
- [x] Vistas: prospects, customers, billing, services
- [x] Historial de cambios por contacto (contact_logs)
- [x] Integración lista para n8n (invoice_reminders)
- [x] Tickets de soporte (support_tickets + support_ticket_notes)
- [x] Blog: migraciones, modelos y controladores en inglés
- [ ] customers/show — detalle de cliente con servicios
- [ ] SupportController y vistas de tickets
- [ ] Notificaciones automáticas con n8n

---

## 📌 Pendientes

### Blog (en curso)
- [ ] Crear `BlogPostPolicy` (reemplaza el trait `GestionaContenidoPorRol`, que nunca existió en este proyecto)
- [ ] Revisar `PermissionSeeder`: definir permisos del blog y qué roles los tienen
- [ ] Actualizar `routes/admin.php`: controladores renombrados, parámetro `{category}`, método `setDefault`, `uploadContentImage`
- [ ] Actualizar vistas admin: campos del formulario y variables en inglés (`$categories`, `$slots`, `$authors`, `$counts`)
- [ ] Renombrar carpeta `resources/views/admin/blog/categorias` → `categories`
- [ ] Actualizar JS de Quill: campo de subida `image` y nueva ruta
- [ ] Actualizar `PageController` y vistas públicas: `published()`, `incrementViews()`, columnas en inglés
- [ ] Actualizar `PermissionSeeder` si usa nombres viejos

### Autorización
- [ ] Revisar `role:administrator` en `routes/admin.php` (líneas 79 y 145) y evaluar pasarlos a permisos
- [ ] **Refactor futuro:** `ContactPolicy` — hoy un `sales-agent` solo ve los prospectos asignados a él (regla por registro). Esa lógica debería vivir en una Policy siguiendo la arquitectura de autorización

### Seguridad
- [ ] Sacar la contraseña del administrador de `UserSeeder` y leerla desde `.env`
- [ ] Cambiar la contraseña del administrador si el seeder ya se subió al repositorio remoto

### Assets y documentación
- [ ] Verificar que Lucide se cargue localmente vía npm (sin CDN)
- [ ] Documentar las tablas `subscribers` y `settings` en este README