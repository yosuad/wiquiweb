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

Sistema desarrollado con **Laravel 12** para administrar prospectos, clientes, servicios y facturación. Incluye automatizaciones con n8n, control de roles y notificaciones automáticas.

- Gestión de prospectos y leads con pipeline de ventas
- Clientes activos con seguimiento de servicios contratados
- Facturación con recordatorios automáticos (n8n)
- Catálogo de servicios con precios por región y tipo de cliente
- Panel de administración con roles y permisos (Spatie)

---

## 🔐 Autenticación y Roles

### Laravel Breeze
Starter kit oficial para autenticación. Incluye registro, login, recuperación de contraseña y panel básico de usuario.

### Spatie Laravel Permission
Manejo de roles y permisos del equipo interno.

| Rol | Descripción |
|-----|-------------|
| `admin` | Control total del sistema |
| `agent` | Supervisor — recluta y gestiona sales-agents |
| `sales-agent` | Vende, crea prospectos y cierra ventas |
| `billing-agent` | Gestiona facturas y pagos |
| `support` | Atiende clientes activos e implementaciones |

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
Admin valida que el dinero llegó → Aprueba factura
        ↓
Contacto se convierte en "customer" → pasa a vista Customers
        ↓
Soporte recibe el cliente para implementación
```

**Roles involucrados en el flujo:**
- `sales-agent` → cierra la venta y marca cuando el cliente paga
- `admin` → valida el pago y aprueba la factura
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
| `paid` | Cliente pagó — pendiente validación del admin |
| `approved` | Admin validó el pago — contacto pasa a cliente |
| `cancelled` | Factura anulada |

### Servicios (`/services`)
Catálogo de servicios con precios configurables por región, tipo de cliente y ciclo de facturación.

| Campo precio | Opciones |
|-------------|----------|
| Región | Colombia / Internacional |
| Tipo de cliente | Persona natural / Empresa / Emprendimiento / Artista / Organización social |
| Ciclo | Pago mensual / Pago anual / Pago único |

---

## 🗄️ Estructura de Base de Datos

### `users`
Usuarios internos del sistema (agentes, admins, soporte).

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre |
| email | VARCHAR | Email único |
| password | VARCHAR | Contraseña |
| status | ENUM | `pending` / `approved` / `rejected` |
| whatsapp | VARCHAR | WhatsApp |
| phone | VARCHAR | Teléfono |

> Todo usuario nuevo queda en `pending` hasta ser aprobado manualmente.

### `services`
Catálogo de servicios ofrecidos.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre del servicio |
| slug | VARCHAR | Identificador único |
| description | TEXT | Descripción opcional |

### `service_prices`
Precios por servicio, región, tipo de cliente y ciclo.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| service_id | BIGINT | FK → services.id |
| region | ENUM | `colombia` / `international` |
| client_type | ENUM | `persona_natural` / `empresa` / `emprendimiento` / `artista` / `organizacion_social` |
| billing_cycle | ENUM | `monthly` / `annual` / `one_time` |
| plan | VARCHAR | Nombre del plan (opcional) |
| price | DECIMAL | Precio en USD |
| currency | CHAR(3) | `USD` |

### `contacts`
Prospectos y clientes del CRM.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| first_name | VARCHAR | Nombre |
| last_name | VARCHAR | Apellido |
| email | VARCHAR | Email único |
| whatsapp | VARCHAR | WhatsApp |
| phone | VARCHAR | Teléfono |
| company_name | VARCHAR | Empresa |
| region | ENUM | `colombia` / `international` |
| client_type | ENUM | `persona_natural` / `empresa` / `emprendimiento` / `artista` / `organizacion_social` |
| origin | ENUM | `facebook` / `instagram` / `referido` / `web` / `agente` / `meta` |
| service_interest | VARCHAR | Servicio de interés |
| assigned_to | BIGINT | FK → users.id |
| status | ENUM | `prospect` / `customer` / `lost` |
| pipeline_stage | ENUM | `new` / `closing` / `pending_payment` |

### `contact_services`
Servicios contratados por cada cliente.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_id | BIGINT | FK → contacts.id |
| service_id | BIGINT | FK → services.id |
| service_price_id | BIGINT | FK → service_prices.id |
| price | DECIMAL | Precio congelado al momento del contrato |
| billing_cycle | ENUM | `monthly` / `annual` / `one_time` |
| status | ENUM | `active` / `suspended` / `cancelled` |
| started_at | DATE | Fecha de inicio |

### `invoices`
Facturas generadas para cada servicio contratado.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| contact_service_id | BIGINT | FK → contact_services.id |
| amount | DECIMAL | Monto congelado al momento de facturar |
| status | ENUM | `pending` / `paid` / `approved` / `cancelled` |
| created_by | BIGINT | FK → users.id |
| paid_at | TIMESTAMP | Fecha de pago |
| approved_at | TIMESTAMP | Fecha de aprobación |

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

### `contact_notes`
Notas internas de seguimiento por contacto.

### `contact_logs`
Historial de cambios de estado y asignaciones por contacto.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| type | VARCHAR | `status_change` / `assignment_change` |
| from | VARCHAR | Valor anterior |
| to | VARCHAR | Valor nuevo |
| created_by | BIGINT | FK → users.id |

### `support_tickets`
Tickets de soporte asociados a servicios contratados.

| Campo | Tipo | Descripción |
|-------|------|-------------|
| contact_service_id | BIGINT | FK → contact_services.id |
| assigned_to | BIGINT | FK → users.id |
| subject | VARCHAR | Asunto |
| status | ENUM | `open` / `in_progress` / `resolved` / `closed` |
| priority | ENUM | `low` / `medium` / `high` |

---

## 🔄 Flujo de Relaciones

```
users (agentes/admins)
  ↓ assigned_to
contacts (prospectos/clientes)
  ↓
contact_services ← services → service_prices
  ↓
invoices → invoice_reminders (n8n)
  ↓
support_tickets
```

---

## ✅ Estado del Proyecto

- [x] Autenticación con Laravel Breeze
- [x] Roles con Spatie Laravel Permission
- [x] Migraciones y modelos
- [x] Pipeline de prospectos (new → closing → pending_payment)
- [x] Flujo de facturación (pending → paid → approved)
- [x] Vistas: prospects, customers, billing, services
- [x] Historial de cambios por contacto (contact_logs)
- [x] Integración lista para n8n (invoice_reminders)
- [ ] customers/show — detalle de cliente con servicios
- [ ] SupportController y vistas de tickets
- [ ] Notificaciones automáticas con n8n