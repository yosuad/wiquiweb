{{--
    Editar cliente (panel)
    - Arriba: datos informativos de solo lectura (origen, tipo, servicio).
    - novalidate: valida Laravel y muestra todos los errores a la vez.
    - Datos obligatorios mientras sea cliente (ContactController@customerUpdate);
      dejan de serlo si se marca como Perdido.
    - WhatsApp y teléfono: componente <x-phone-input>.
    - Historial: componente <x-contact-history>.
--}}

@extends('layouts.admin')

@section('title', 'Editar cliente')

@php
    $pageTitle = 'Editar cliente';

    // Valores guardados → texto legible
    $originLabels = [
        'facebook' => 'Facebook',
        'instagram' => 'Instagram',
        'referido' => 'Referido',
        'web' => 'Web',
        'agente' => 'Agente',
        'meta' => 'Meta',
    ];
    $clientTypeLabels = [
        'persona_natural' => 'Persona natural',
        'empresa' => 'Empresa',
        'emprendimiento' => 'Emprendimiento',
        'artista' => 'Artista',
        'organizacion_social' => 'Organización social',
    ];
    // Lista única de servicios: config/leads.php
    $serviceLabels = config('leads.services');
@endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Editar cliente</p>
            <a href="{{ route('customers') }}" class="btn-secondary">
                <i data-lucide="arrow-left"></i> Volver a clientes
            </a>
        </div>
    </div>

    {{-- Datos informativos (solo lectura) --}}
    <div class="form-container form-container--info">
        <div class="form-row">
            <div class="form-group">
                <label>Origen</label>
                <div class="form-input form-input--readonly">
                    {{ $originLabels[$contact->origin] ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Tipo de cliente</label>
                <div class="form-input form-input--readonly">
                    {{ $clientTypeLabels[$contact->client_type] ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Servicio de interés</label>
                <div class="form-input form-input--readonly">
                    {{ $serviceLabels[$contact->service_interest] ?? ($contact->service_interest ?? '—') }}
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('customers.update', $contact->id) }}" novalidate>
            @csrf
            @method('PUT')

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
                    <label for="last_name">Apellido <span class="required">*</span></label>
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
                    <label for="company_name">Empresa <span class="required">*</span></label>
                    <input type="text" id="company_name" name="company_name"
                        value="{{ old('company_name', $contact->company_name) }}"
                        class="form-input @error('company_name') is-invalid @enderror" placeholder="Nombre de la empresa">
                    @error('company_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 4: Tipo y Número de documento --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="document_type">Tipo de documento <span class="required">*</span></label>
                    <select id="document_type" name="document_type"
                        class="form-input @error('document_type') is-invalid @enderror">
                        <option value="" disabled
                            {{ old('document_type', $contact->document_type) ? '' : 'selected' }}>— Seleccionar —</option>
                        <option value="national_id"
                            {{ old('document_type', $contact->document_type) == 'national_id' ? 'selected' : '' }}>CC —
                            Cédula de ciudadanía</option>
                        <option value="tax_id"
                            {{ old('document_type', $contact->document_type) == 'tax_id' ? 'selected' : '' }}>NIT —
                            Número de identificación tributaria</option>
                        <option value="rut"
                            {{ old('document_type', $contact->document_type) == 'rut' ? 'selected' : '' }}>RUT —
                            Registro único tributario</option>
                        <option value="foreign_id"
                            {{ old('document_type', $contact->document_type) == 'foreign_id' ? 'selected' : '' }}>CE —
                            Cédula de extranjería</option>
                        <option value="passport"
                            {{ old('document_type', $contact->document_type) == 'passport' ? 'selected' : '' }}>
                            Pasaporte</option>
                        <option value="ein"
                            {{ old('document_type', $contact->document_type) == 'ein' ? 'selected' : '' }}>EIN —
                            Employer Identification Number (EE. UU.)</option>
                    </select>
                    @error('document_type')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="document_number">Número de documento <span class="required">*</span></label>
                    <input type="text" id="document_number" name="document_number"
                        value="{{ old('document_number', $contact->document_number) }}"
                        class="form-input @error('document_number') is-invalid @enderror" placeholder="Ej: 1234567890">
                    @error('document_number')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            {{-- Fila 5: Dirección --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="address">Dirección <span class="required">*</span></label>
                    <input type="text" id="address" name="address" value="{{ old('address', $contact->address) }}"
                        class="form-input @error('address') is-invalid @enderror"
                        placeholder="Ej: Calle 123 #45-67, Medellín">
                    @error('address')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group"></div>
            </div>

            {{-- Fila 6: Asignado a y Estado --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="assigned_to">Asignado a <span class="required">*</span></label>
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
                    <label for="status">Estado</label>
                    <select id="status" name="status" class="form-input">
                        <option value="customer" {{ old('status', $contact->status) == 'customer' ? 'selected' : '' }}>
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
