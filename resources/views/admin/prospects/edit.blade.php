@extends('layouts.admin')

@section('title', 'Edit Lead')

@php $pageTitle = 'Edit Lead'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Edit prospect</p>
            <a href="{{ route($redirectTo) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.update', $contact->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

            {{-- Row 1: First name and Last name --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name"
                        value="{{ old('first_name', $contact->first_name) }}"
                        class="form-input @error('first_name') is-invalid @enderror" placeholder="First name">
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name"
                        value="{{ old('last_name', $contact->last_name) }}" class="form-input" placeholder="Last name">
                </div>
            </div>

            {{-- Row 2: WhatsApp and Phone --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $contact->whatsapp) }}"
                        class="form-input" placeholder="+57 320 413 25 00" inputmode="tel" pattern="[\+\d\s\-\(\)]{7,20}"
                        title="Solo números, +, espacios, guiones y paréntesis">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $contact->phone) }}"
                        class="form-input" placeholder="+57 300 758 35 00" inputmode="tel" pattern="[\+\d\s\-\(\)]{7,20}"
                        title="Solo números, +, espacios, guiones y paréntesis">
                </div>
            </div>

            {{-- Row 3: Email and Company --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $contact->email) }}"
                        class="form-input @error('email') is-invalid @enderror" placeholder="email@example.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Company</label>
                    <input type="text" id="company_name" name="company_name"
                        value="{{ old('company_name', $contact->company_name) }}" class="form-input"
                        placeholder="Company name (optional)">
                </div>
            </div>

            {{-- Row 4: Assigned and Origin --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="assigned_to">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="">— Select —</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ (int) old('assigned_to', $contact->assigned_to) === $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="origin">Origin</label>
                    <select id="origin" name="origin" class="form-input">
                        <option value="">— Select —</option>
                        <option value="facebook"  {{ old('origin', $contact->origin) == 'facebook'  ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('origin', $contact->origin) == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="referido"  {{ old('origin', $contact->origin) == 'referido'  ? 'selected' : '' }}>Referido</option>
                        <option value="agente"    {{ old('origin', $contact->origin) == 'agente'    ? 'selected' : '' }}>Agente</option>
                        <option value="meta"      {{ old('origin', $contact->origin) == 'meta'      ? 'selected' : '' }}>Meta</option>
                        <option value="web"       {{ old('origin', $contact->origin) == 'web'       ? 'selected' : '' }}>Web</option>
                    </select>
                </div>
            </div>

            {{-- Row 5: Client type and Service interest --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="client_type">Client type</label>
                    <select id="client_type" name="client_type" class="form-input">
                        <option value="">— Select —</option>
                        <option value="persona_natural"     {{ old('client_type', $contact->client_type) == 'persona_natural'     ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type', $contact->client_type) == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type', $contact->client_type) == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type', $contact->client_type) == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type', $contact->client_type) == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="service_interest">Service interest</label>
                    <select id="service_interest" name="service_interest" class="form-input">
                        <option value="">— Select —</option>
                        <option value="pagina_web"           {{ old('service_interest', $contact->service_interest) == 'pagina_web'           ? 'selected' : '' }}>Página web</option>
                        <option value="asistente_virtual"    {{ old('service_interest', $contact->service_interest) == 'asistente_virtual'    ? 'selected' : '' }}>Asistente virtual</option>
                        <option value="landing_page"         {{ old('service_interest', $contact->service_interest) == 'landing_page'         ? 'selected' : '' }}>Landing page</option>
                        <option value="crm"                  {{ old('service_interest', $contact->service_interest) == 'crm'                  ? 'selected' : '' }}>CRM</option>
                        <option value="erp"                  {{ old('service_interest', $contact->service_interest) == 'erp'                  ? 'selected' : '' }}>ERP</option>
                        <option value="campana_publicitaria" {{ old('service_interest', $contact->service_interest) == 'campana_publicitaria' ? 'selected' : '' }}>Campaña publicitaria</option>
                        <option value="diseno"               {{ old('service_interest', $contact->service_interest) == 'diseno'               ? 'selected' : '' }}>Diseño</option>
                    </select>
                </div>
            </div>

            {{-- Row 6: Status --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="prospect" {{ old('status', $contact->status) == 'prospect' ? 'selected' : '' }}>Prospect</option>
                        <option value="customer" {{ old('status', $contact->status) == 'customer' || $contact->pipeline_stage == 'closing' ? 'selected' : '' }}>Customer</option>
                        <option value="lost"     {{ old('status', $contact->status) == 'lost'     ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update lead
                </button>
            </div>

        </form>
    </div>

    {{-- Contact history log --}}
    <div class="form-container" style="margin-top: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
            <i class="fas fa-clock-rotate-left" style="color: var(--primary-color);"></i> Contact History
        </h3>

        <div class="dash-activity">
            @forelse($logs as $log)
                <div class="dash-activity__item">
                    @if ($log->type === 'status_change')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $log->author->name ?? '—' }}</strong>
                            @if ($log->from === null)
                                registered contact as
                                <span class="badge badge-new" style="font-size:0.7rem;">{{ ucfirst($log->to) }}</span>
                            @else
                                changed status from
                                <span class="badge {{ $log->from === 'prospect' ? 'badge-new' : ($log->from === 'customer' ? 'badge-closed' : 'badge-lost') }}" style="font-size:0.7rem;">{{ ucfirst($log->from) }}</span>
                                to
                                <span class="badge {{ $log->to === 'prospect' ? 'badge-new' : ($log->to === 'customer' ? 'badge-closed' : 'badge-lost') }}" style="font-size:0.7rem;">{{ ucfirst($log->to) }}</span>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @elseif($log->type === 'assignment_change')
                        <div class="dash-activity__dot dash-activity__dot--blue"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $log->author->name ?? '—' }}</strong>
                            @if ($log->from === null)
                                assigned to <em>{{ $log->to }}</em>
                            @else
                                reassigned from <em>{{ $log->from }}</em> to <em>{{ $log->to }}</em>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="dash-empty">No history recorded yet.</p>
            @endforelse
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        ['whatsapp', 'phone'].forEach(id => {
            document.getElementById(id).addEventListener('input', function() {
                this.value = this.value.replace(/[^\d\+\s\-\(\)]/g, '');
            });
        });
    </script>
@endpush