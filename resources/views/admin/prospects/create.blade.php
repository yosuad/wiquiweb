{{--
    Crear prospecto (panel)
    - novalidate: el navegador no valida; valida Laravel y muestra todos
      los errores a la vez, debajo de cada campo.
    - WhatsApp y teléfono: componente <x-phone-input> (bandera + país).
--}}

@extends('layouts.admin')

@section('title', 'Nuevo prospecto')

@php $pageTitle = 'Nuevo prospecto'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Registrar un nuevo prospecto</p>
            <a href="{{ route('prospects.index') }}" class="btn-secondary">
                <i data-lucide="arrow-left"></i> Volver a prospectos
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.store') }}" novalidate>
            @csrf

            {{-- Fila 1: Nombre y Apellido --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">Nombre <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                        class="form-input @error('first_name') is-invalid @enderror" placeholder="Nombre">
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Apellido</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-input"
                        placeholder="Apellido">
                </div>
            </div>

            {{-- Fila 2: WhatsApp y Teléfono --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp <span class="required">*</span></label>
                    <x-phone-input name="whatsapp" id="whatsapp" placeholder="320 569 3258"
                        class="form-input {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" />
                    @error('whatsapp')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono</label>
                    <x-phone-input name="phone" id="phone" placeholder="300 758 3500"
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
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror" placeholder="correo@ejemplo.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Empresa</label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                        class="form-input" placeholder="Nombre de la empresa (opcional)">
                </div>
            </div>

            {{-- Fila 4: Origen y Tipo de cliente --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="origin">Origen</label>
                    <select id="origin" name="origin" class="form-input">
                        <option value="" disabled selected>— Seleccionar —</option>
                        <option value="facebook" {{ old('origin') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('origin') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="referido" {{ old('origin') == 'referido' ? 'selected' : '' }}>Referido</option>
                        <option value="agente" {{ old('origin') == 'agente' ? 'selected' : '' }}>Agente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="client_type">Tipo de cliente</label>
                    <select id="client_type" name="client_type" class="form-input">
                        <option value="" disabled selected>— Seleccionar —</option>
                        <option value="persona_natural" {{ old('client_type') == 'persona_natural' ? 'selected' : '' }}>
                            Persona natural</option>
                        <option value="empresa" {{ old('client_type') == 'empresa' ? 'selected' : '' }}>Empresa
                        </option>
                        <option value="emprendimiento" {{ old('client_type') == 'emprendimiento' ? 'selected' : '' }}>
                            Emprendimiento</option>
                        <option value="artista" {{ old('client_type') == 'artista' ? 'selected' : '' }}>Artista
                        </option>
                        <option value="organizacion_social"
                            {{ old('client_type') == 'organizacion_social' ? 'selected' : '' }}>Organización social
                        </option>
                    </select>
                </div>
            </div>

            {{-- Fila 5: Servicio de interés y Agente asignado --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="service_interest">Servicio de interés</label>
                    <select id="service_interest" name="service_interest" class="form-input">
                        <option value="" disabled selected>— Seleccionar —</option>
                        {{-- Lista única de servicios: config/leads.php --}}
                        @foreach (config('leads.services') as $value => $label)
                            <option value="{{ $value }}" @selected(old('service_interest') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="assigned_to">Asignado a</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="" disabled selected>— Seleccionar —</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ old('assigned_to', auth()->id()) == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i data-lucide="save"></i> Guardar prospecto
                </button>
            </div>

        </form>
    </div>

@endsection
