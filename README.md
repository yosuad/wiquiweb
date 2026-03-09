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

# 📋 Sistema de Gestión de Servicios y Facturación

Sistema desarrollado con **Laravel** para administrar prospectos, clientes, servicios y facturación mensual. Incluye automatizaciones con n8n, control de roles y notificaciones automáticas.

- Gestión de prospectos y leads
- Clientes activos y tareas pendientes
- Facturación mensual con recordatorios automáticos (n8n)
- Catálogo de servicios con precios históricos
- Panel de administración con roles y permisos

---

## 🔐 Autenticación y Roles

### Laravel Breeze
Starter kit oficial para autenticación. Incluye registro, login, recuperación de contraseña y panel básico de usuario.

### Spatie Laravel Permission
Manejo de roles y permisos del equipo interno.

| Rol | Descripción |
|-----|-------------|
| Admin | Acceso total al sistema |
| Editor | Gestión de contenido y servicios |
| Agente de cobros | Acceso a billing y seguimiento de pagos |
| Agente de ventas | Gestión de prospectos y clientes |
| Soporte | Atención y seguimiento de clientes activos |

---

## 🖥️ Páginas del Panel

Solo accesibles para usuarios autenticados y verificados (`auth`, `verified`).

| Ruta | Nombre | Descripción |
|------|--------|-------------|
| `/dashboard` | Dashboard | Panel general de control |
| `/prospects` | Prospectos | Leads, seguimiento y correos de conversión |
| `/customers` | Clientes | Clientes activos y tareas pendientes |
| `/billing` | Facturación | Planes, mensualidades, pagos y suscripciones |
| `/services` | Servicios | Catálogo de servicios ofrecidos |
| `/admin` | Administración | Usuarios internos y privilegios elevados |

---

## 📄 Vistas

### Prospectos
Gestión de leads desde su primer contacto. Al inicio solo se tiene el nombre; el equipo llama y completa el formulario.

| Campo | Descripción |
|-------|-------------|
| Empresa | Puede estar vacía al inicio, se llena tras la llamada |
| Nombre | Dato inicial del prospecto |
| Teléfono | Contacto principal |
| Correo | Opcional, se completa tras la llamada |
| Origen | Facebook, Instagram, Referido, Web |
| Servicio | Servicio de interés detectado |
| Estado | Nuevo / Contactado / Seguimiento / Cerrado |
| Fecha | Fecha de registro del lead |
| Llamada | Checkbox que indica si se realizó la llamada |
| Nota de seguimiento | Texto libre con observaciones del agente |

### Clientes
Clientes que ya tienen un servicio contratado. La comunicación es fluida por correo, sin métricas de mensajes.

| Campo | Descripción |
|-------|-------------|
| Empresa | Nombre de la empresa del cliente |
| Nombre | Nombre del contacto principal |
| Teléfono | Número de contacto |
| Correo | Correo electrónico |
| Servicio | Servicio contratado activo |
| Estado | Activo / En pausa / Inactivo |
| Desde | Fecha de inicio del servicio |
| Tarea pendiente | Entrega o acción pendiente del equipo |

### Facturación
Seguimiento de pagos mensuales. Los recordatorios los genera n8n automáticamente. El equipo registra novedades tras la llamada de cobro.

| Campo | Descripción |
|-------|-------------|
| Empresa | Nombre de la empresa |
| Nombre | Contacto de pago |
| Teléfono | Número para cobro |
| Monto | Valor de la mensualidad en USD |
| Mes | Mes de facturación |
| Msg 15d | Recordatorio automático por n8n a los 15 días de mora |
| Msg 30d | Recordatorio automático por n8n a los 30 días de mora |
| Última novedad | Nota manual del equipo tras la llamada de cobro |

> La vista tiene filtro por estado: **Pendiente** (aún no han pagado) y **Pagado** (pago realizado).

### Servicios
Catálogo de servicios activos ofrecidos.

| Servicio | Descripción | Precio |
|----------|-------------|--------|
| Hosting | Alojamiento web para sitios y aplicaciones | $80 USD / mes |
| Dominio | Registro y gestión de nombre de dominio | $200 USD / año |
| Automatizaciones | Implementación de flujos con n8n | $400 USD implementación + $100 USD / mes |
| Actualizaciones | Mantenimiento y actualización de sitios web | A convenir |
| Asesorías | Consultoría en estrategia digital | A convenir |
| Diseño Gráfico | Piezas gráficas para redes y medios digitales | A convenir |
| Diseño de Logos | Identidad visual y logotipo | A convenir |

### Administración
Gestión de usuarios internos con acceso al panel.

| Campo | Descripción |
|-------|-------------|
| Nombre | Nombre del usuario interno |
| Correo | Correo de acceso al sistema |
| Rol | Admin / Editor / Agente de cobros / Agente de ventas / Soporte |
| Estado | Activo / Inactivo |

---

## 🗄️ Estructura de Base de Datos

Diseñada para soportar precios variables por año sin afectar facturas anteriores.

### `users`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre del usuario |
| email | VARCHAR | Email único |
| password | VARCHAR | Contraseña |
| status | ENUM | pending / approved / rejected |
| phone | VARCHAR | Teléfono |
| address | VARCHAR | Dirección |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

> Todo usuario nuevo queda en estado `pending` hasta ser aprobado manualmente. Solo se aprueban usuarios que adquieren un servicio.

### `services`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| name | VARCHAR | Nombre del servicio |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

### `service_prices`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| service_id | BIGINT | FK → services.id |
| type | ENUM | monthly / annual |
| year | YEAR | Año de vigencia |
| price | DECIMAL(10,2) | Precio definido |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

> Permite que los precios cambien cada año sin afectar facturas anteriores.

### `user_services`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| user_id | BIGINT | FK → users.id |
| service_id | BIGINT | FK → services.id |
| start_date | DATE | Fecha de inicio del servicio |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

### `invoices`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| user_service_id | BIGINT | FK → user_services.id |
| type | ENUM | monthly / annual |
| month | TINYINT | 1-12 (nullable si es anual) |
| year | YEAR | Año de la factura |
| amount | DECIMAL(10,2) | Monto final congelado al momento de facturar |
| status | ENUM | pending / paid / overdue |
| paid_at | DATE | Fecha de pago (nullable) |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

> El campo `amount` guarda el precio final tomado desde `service_prices`. Aunque el precio cambie en el futuro, la factura mantiene su valor original. Esto garantiza integridad contable.

### `invoice_notifications`

| Campo | Tipo | Descripción |
|-------|------|-------------|
| id | BIGINT | PK |
| invoice_id | BIGINT | FK → invoices.id |
| reminder_number | TINYINT | 1 (15 días de mora) o 2 (30 días de mora) |
| sent_at | DATETIME | Fecha y hora de envío |
| status | ENUM | sent / failed |
| created_at | TIMESTAMP | Fecha de creación |
| updated_at | TIMESTAMP | Fecha de actualización |

> Tabla para integración con n8n. Se evita enviar recordatorios duplicados y se mantiene historial completo.

---

## 🔄 Flujo de Relaciones

| Tabla origen | Relación | Tabla destino |
|--------------|----------|---------------|
| users | 1 a muchos | user_services |
| services | 1 a muchos | user_services |
| services | 1 a muchos | service_prices |
| user_services | 1 a muchos | invoices |
| invoices | 1 a muchos | invoice_notifications |

```
users
↓
user_services ← services → service_prices
↓
invoices
↓
invoice_notifications
```

---

## ✅ Estado del Proyecto

- [x] Autenticación con Laravel Breeze
- [x] Roles con Spatie Laravel Permission
- [x] Vistas del panel organizadas y funcionales
- [x] Estructura de base de datos diseñada
- [x] Integración con n8n para recordatorios automáticos
- [ ] Migraciones y modelos
- [ ] Controllers y lógica de negocio
- [ ] Conexión con n8n



cuando pasa de prospecto a no califica se pasa a usuarios ahi necesito poder entrar y hacer una busqueda y pode volver abilitarlo



implementacion que es con soporte

15:41
Perfecto, entonces el flujo completo es:

Prospecto cerrado
      ↓
Agente completa datos + genera factura
      ↓
Cliente paga → Agente marca "pagado"
      ↓
Admin valida que el dinero llegó → Aprueba
      ↓
Usuario se convierte en cliente (rol customer)
      ↓
Pasa a Soporte para implementación
Entonces tienes 3 roles involucrados:

Agente → cierra la venta y marca cuando el cliente paga
Admin (tú) → validas el pago y apruebas
Soporte → recibe el cliente para implementación



admin          → control total
agent          → supervisor, recluta y gestiona sales-agents
sales-agent    → vende, crea prospectos y cierra ventas
billing-agent  → gestiona facturas y pagos
support        → atiende clientes activos
prospect       → lead en proceso
customer       → cliente activo