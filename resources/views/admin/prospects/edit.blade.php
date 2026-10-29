{{--
    Editar prospecto (panel)
    - novalidate: valida Laravel y muestra todos los errores a la vez.
    - WhatsApp y teléfono: componente <x-phone-input> (bandera + país).
    - Al elegir "Cliente", aparecen asteriscos en los campos que pasan a ser
      obligatorios (js/admin/prospects/edit.js). La regla real está en
      ContactController@update (required_if:status,customer).
    - Historial: componente <x-contact-history>.
--}}

@extends('layouts.admin')

@section('title', 'Editar prospecto')

@php $pageTitle = 'Editar prospecto'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Editar prospecto</p>
            <a href="{{ route($redirectTo) }}" class="btn-secondary">
                <i data-lucide="arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Campaña de Meta que trajo al lead (solo lectura; solo si vino por un anuncio) --}}
    @if ($contact->campaign || $contact->ad)
        <div class="form-container form-container--info">
            <div class="form-row">
                <div class="form-group">
                    <label>Campaña</label>
                    <div class="form-input form-input--readonly">{{ $contact->campaign ?? '—' }}</div>
                </div>
                <div class="form-group">
                    <label>Anuncio</label>
                    <div class="form-input form-input--readonly">{{ $contact->ad ?? '—' }}</div>
                </div>
            </div>
        </div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.update', $contact->id) }}" novalidate>
            @csrf
            @method('PUT')

            <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

            {{-- Fila 1: Nombre y Apellido --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Nombre <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name"
                        value="{{ old('first_name', $contact->first_name) }}"
                        class="form-input @error('first_name') is-invalid @enderror" placeholder="Nombre">
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Apellido <span class="required" data-customer-required hidden>*</span></label>
                    <input type="text" id="last_name" name="last_name"
                        value="{{ old('last_name', $contact->last_name) }}"
                        class="form-input @error('last_name') is-invalid @enderror" placeholder="Apellido">
                    @error('last_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 2: WhatsApp y Teléfono --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp <span class="required">*</span></label>
                    <x-phone-input name="whatsapp" id="whatsapp" :value="$contact->whatsapp" placeholder="320 569 3258"
                        class="form-input {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" />
                    @error('whatsapp')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <x-phone-input name="phone" id="phone" :value="$contact->phone" placeholder="300 758 3500"
                        class="form-input {{ $errors->has('phone') ? 'is-invalid' : '' }}" />
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 3: Correo y Empresa --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Correo <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $contact->email) }}"
                        class="form-input @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Empresa <span class="required" data-customer-required hidden>*</span></label>
                    <input type="text" id="company_name" name="company_name"
                        value="{{ old('company_name', $contact->company_name) }}"
                        class="form-input @error('company_name') is-invalid @enderror" placeholder="Nombre de la empresa">
                    @error('company_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 4: Asignado a y Origen --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="assigned_to">Asignado a <span class="required" data-customer-required
                            hidden>*</span></label>
                    <select id="assigned_to" name="assigned_to"
                        class="form-input @error('assigned_to') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ (int) old('assigned_to', $contact->assigned_to) === $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="origin">Origen <span class="required" data-customer-required hidden>*</span></label>
                    <select id="origin" name="origin" class="form-input @error('origin') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        <option value="facebook" {{ old('origin', $contact->origin) == 'facebook' ? 'selected' : '' }}>
                            Facebook</option>
                        <option value="instagram" {{ old('origin', $contact->origin) == 'instagram' ? 'selected' : '' }}>
                            Instagram</option>
                        <option value="referido" {{ old('origin', $contact->origin) == 'referido' ? 'selected' : '' }}>
                            Referido</option>
                        <option value="agente" {{ old('origin', $contact->origin) == 'agente' ? 'selected' : '' }}>
                            Agente</option>
                        <option value="meta" {{ old('origin', $contact->origin) == 'meta' ? 'selected' : '' }}>Meta
                        </option>
                        <option value="web" {{ old('origin', $contact->origin) == 'web' ? 'selected' : '' }}>Web
                        </option>
                    </select>
                    @error('origin')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 5: Tipo de cliente y Servicio de interés --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="client_type">Tipo de cliente <span class="required" data-customer-required
                            hidden>*</span></label>
                    <select id="client_type" name="client_type"
                        class="form-input @error('client_type') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        <option value="persona_natural"
                            {{ old('client_type', $contact->client_type) == 'persona_natural' ? 'selected' : '' }}>
                            Persona natural</option>
                        <option value="empresa"
                            {{ old('client_type', $contact->client_type) == 'empresa' ? 'selected' : '' }}>
                            Empresa</option>
                        <option value="emprendimiento"
                            {{ old('client_type', $contact->client_type) == 'emprendimiento' ? 'selected' : '' }}>
                            Emprendimiento</option>
                        <option value="artista"
                            {{ old('client_type', $contact->client_type) == 'artista' ? 'selected' : '' }}>
                            Artista</option>
                        <option value="organizacion_social"
                            {{ old('client_type', $contact->client_type) == 'organizacion_social' ? 'selected' : '' }}>
                            Organización social</option>
                    </select>
                    @error('client_type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="service_interest">Servicio de interés <span class="required" data-customer-required
                            hidden>*</span></label>
                    <select id="service_interest" name="service_interest"
                        class="form-input @error('service_interest') is-invalid @enderror">
                        <option value="">— Seleccionar —</option>
                        {{-- Lista única de servicios: config/leads.php --}}
                        @foreach (config('leads.services') as $value => $label)
                            <option value="{{ $value }}" @selected(old('service_interest', $contact->service_interest) == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('service_interest')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 6: Estado --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="status">Estado</label>
                    <select id="status" name="status" class="form-input">
                        <option value="prospect" {{ old('status', $contact->status) == 'prospect' ? 'selected' : '' }}>
                            Prospecto</option>
                        <option value="customer"
                            {{ old('status', $contact->status) == 'customer' || $contact->pipeline_stage == 'closing' ? 'selected' : '' }}>
                            Cliente</option>
                        <option value="lost" {{ old('status', $contact->status) == 'lost' ? 'selected' : '' }}>
                            Perdido</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i data-lucide="save"></i> Guardar cambios
                </button>
            </div>

        </form>
    </div>

    {{-- Historial del contacto --}}
    <x-contact-history :logs="$logs" />

@endsection

@push('scripts')
    @vite('resources/js/admin/prospects/edit.js')
@endpush
