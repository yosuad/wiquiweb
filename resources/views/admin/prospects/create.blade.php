@extends('layouts.admin')

@section('title', 'Add Lead')

@php $pageTitle = 'Add Lead'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Register new prospect</p>
            <a href="{{ route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to prospects
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.store') }}">
            @csrf

            {{-- Row 1: First name and Last name --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                        class="form-input @error('first_name') is-invalid @enderror" placeholder="First name">
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" class="form-input"
                        placeholder="Last name">
                </div>
            </div>

            {{-- Row 2: WhatsApp and Phone --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="tel" id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}"
                        class="form-input" placeholder="+57 320 413 25 00"
                        inputmode="tel" pattern="[\+\d\s\-\(\)]{7,20}"
                        title="Solo números, +, espacios, guiones y paréntesis">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                        class="form-input" placeholder="+57 300 758 35 00"
                        inputmode="tel" pattern="[\+\d\s\-\(\)]{7,20}"
                        title="Solo números, +, espacios, guiones y paréntesis">
                </div>
            </div>

            {{-- Row 3: Email and Company --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                        class="form-input @error('email') is-invalid @enderror" placeholder="email@example.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Company</label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                        class="form-input" placeholder="Company name (optional)">
                </div>
            </div>

            {{-- Row 4: Origin and Client type --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="origin">Origin</label>
                    <select id="origin" name="origin" class="form-input">
                        <option value="" disabled selected>— Select —</option>
                        <option value="facebook"  {{ old('origin') == 'facebook'  ? 'selected' : '' }}>Facebook</option>
                        <option value="instagram" {{ old('origin') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        <option value="referido"  {{ old('origin') == 'referido'  ? 'selected' : '' }}>Referido</option>
                        <option value="agente"    {{ old('origin') == 'agente'    ? 'selected' : '' }}>Agente</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="client_type">Client type</label>
                    <select id="client_type" name="client_type" class="form-input">
                        <option value="" disabled selected>— Select —</option>
                        <option value="persona_natural"     {{ old('client_type') == 'persona_natural'     ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type') == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type') == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type') == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type') == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                </div>
            </div>

            {{-- Row 5: Service interest and Assigned agent --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="service_interest">Service interest</label>
                    <select id="service_interest" name="service_interest" class="form-input">
                        <option value="" disabled selected>— Select —</option>
                        <option value="pagina_web"           {{ old('service_interest') == 'pagina_web'           ? 'selected' : '' }}>Página web</option>
                        <option value="asistente_virtual"    {{ old('service_interest') == 'asistente_virtual'    ? 'selected' : '' }}>Asistente virtual</option>
                        <option value="landing_page"         {{ old('service_interest') == 'landing_page'         ? 'selected' : '' }}>Landing page</option>
                        <option value="crm"                  {{ old('service_interest') == 'crm'                  ? 'selected' : '' }}>CRM</option>
                        <option value="erp"                  {{ old('service_interest') == 'erp'                  ? 'selected' : '' }}>ERP</option>
                        <option value="campana_publicitaria" {{ old('service_interest') == 'campana_publicitaria' ? 'selected' : '' }}>Campaña publicitaria</option>
                        <option value="diseno"               {{ old('service_interest') == 'diseno'               ? 'selected' : '' }}>Diseño</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="assigned_to">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="" disabled selected>— Select —</option>
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
                    <i class="fas fa-save"></i> Save lead
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    ['whatsapp', 'phone'].forEach(id => {
        document.getElementById(id).addEventListener('input', function () {
            this.value = this.value.replace(/[^\d\+\s\-\(\)]/g, '');
        });
    });
</script>
@endpush