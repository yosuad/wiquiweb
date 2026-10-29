{{--
    Historial de un contacto (contact_logs).
    Uso: <x-contact-history :logs="$logs" />
    Usado en: admin/prospects/edit y admin/customers/edit
    CSS: css/admin/base/contact-history.css

    Tipos de evento:
    - status_change      → cambio de estado (o registro inicial si from = null)
    - assignment_change  → asignación o reasignación de agente
    - returned           → volvió a llenar un formulario público
    - whatsapp_mismatch  → volvió con otro WhatsApp (se muestran los dos)
    - email_mismatch     → volvió con otro correo (se muestran los dos)
    Los eventos del sistema (created_by = null) se muestran como "Sistema".
    El formato de los teléfonos lo da el modelo: Contact::formatForDisplay().
--}}

@props(['logs'])

@php
    // Estados en español y su color de badge
    $statusLabels = ['prospect' => 'Prospecto', 'customer' => 'Cliente', 'lost' => 'Perdido'];
    $statusBadges = ['prospect' => 'badge-new', 'customer' => 'badge-closed', 'lost' => 'badge-lost'];

    // Servicios en texto legible (lista única: config/leads.php)
    $serviceLabels = config('leads.services');
@endphp

<div class="form-container contact-history">
    <h3 class="contact-history__title">
        <i data-lucide="history" class="contact-history__icon"></i> Historial del contacto
    </h3>

    <div class="dash-activity">
        @forelse ($logs as $log)
            @php $author = $log->author->name ?? 'Sistema'; @endphp

            <div class="dash-activity__item">
                @switch($log->type)
                    {{-- Cambio de estado --}}
                    @case('status_change')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $author }}</strong>
                            @if ($log->from === null)
                                registró el contacto como
                                <span
                                    class="badge badge--sm {{ $statusBadges[$log->to] ?? 'badge-new' }}">{{ $statusLabels[$log->to] ?? $log->to }}</span>
                            @else
                                cambió el estado:
                                <span
                                    class="badge badge--sm {{ $statusBadges[$log->from] ?? 'badge-new' }}">{{ $statusLabels[$log->from] ?? $log->from }}</span>
                                <span class="contact-history__arrow">→</span>
                                <span
                                    class="badge badge--sm {{ $statusBadges[$log->to] ?? 'badge-new' }}">{{ $statusLabels[$log->to] ?? $log->to }}</span>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Asignación de agente --}}
                    @case('assignment_change')
                        <div class="dash-activity__dot dash-activity__dot--blue"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $author }}</strong>
                            @if ($log->from === null)
                                lo asignó a <em>{{ $log->to }}</em>
                            @else
                                lo reasignó de <em>{{ $log->from }}</em> a <em>{{ $log->to }}</em>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Volvió a escribir por un formulario público --}}
                    @case('returned')
                        <div class="dash-activity__dot dash-activity__dot--blue"></div>
                        <div class="dash-activity__text">
                            <strong>Volvió a escribir</strong> por el {{ $log->to }}
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Volvió con otro WhatsApp --}}
                    @case('whatsapp_mismatch')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>Escribió con otro WhatsApp:</strong>
                            {{ \App\Models\Contact::formatForDisplay($log->to) ?? '—' }}
                            (registrado: {{ \App\Models\Contact::formatForDisplay($log->from) ?? '—' }})
                            .
                            Verifica cuál es el correcto.
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Volvió con otro correo --}}
                    @case('email_mismatch')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>Escribió con otro correo:</strong> {{ $log->to }}
                            (registrado: {{ $log->from }}). Verifica cuál es el correcto.
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Volvió con otro nombre --}}
                    @case('name_mismatch')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>Escribió otro nombre:</strong> {{ $log->to }}
                            (registrado: {{ $log->from }}). Verifica cuál es el correcto.
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break

                    {{-- Pidió otro servicio (el anterior → el nuevo) --}}
                    @case('service_change')
                        <div class="dash-activity__dot dash-activity__dot--blue"></div>
                        <div class="dash-activity__text">
                            <strong>Cambió su interés:</strong>
                            <span
                                class="badge badge--sm badge-follow">{{ $serviceLabels[$log->from] ?? ($log->from ?: 'Sin servicio') }}</span>
                            <span class="contact-history__arrow">→</span>
                            <span class="badge badge--sm badge-follow">{{ $serviceLabels[$log->to] ?? $log->to }}</span>
                            <span class="dash-activity__time">{{ $log->created_at->locale('es')->diffForHumans() }}</span>
                        </div>
                    @break
                @endswitch
            </div>
            @empty
                <p class="dash-empty">Todavía no hay historial.</p>
            @endforelse
        </div>
    </div>
