@extends('layouts.admin')

@section('title', 'Cerrar Venta')

@php $pageTitle = 'Cerrar Venta'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Cerrar venta — {{ $user->name }} {{ $user->last_name }}</p>
            <a href="{{ route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a prospectos
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.invoice.generate', $user->id) }}">
            @csrf

            {{-- Fila 1: Región y Tipo de cliente --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="region">Región <span class="required">*</span></label>
                    <select id="region" name="region" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Seleccionar —</option>
                        <option value="colombia" {{ old('region') == 'colombia' ? 'selected' : '' }}>Colombia</option>
                        <option value="exterior" {{ old('region') == 'exterior' ? 'selected' : '' }}>Exterior</option>
                    </select>
                    @error('region') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="client_type">Tipo de cliente <span class="required">*</span></label>
                    <select id="client_type" name="client_type" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Seleccionar —</option>
                        <option value="natural"             {{ old('client_type') == 'natural'             ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type') == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type') == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type') == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type') == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                    @error('client_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Fila 2: Servicio y Ciclo --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="service_id">Servicio <span class="required">*</span></label>
                    <select id="service_id" name="service_id" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Seleccionar —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('service_id', $user->prospectDetail->service_id ?? '') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="billing_cycle">Ciclo <span class="required">*</span></label>
                    <select id="billing_cycle" name="billing_cycle" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Seleccionar —</option>
                        <option value="monthly"  {{ old('billing_cycle') == 'monthly'  ? 'selected' : '' }}>Mensual</option>
                        <option value="annual"   {{ old('billing_cycle') == 'annual'   ? 'selected' : '' }}>Anual</option>
                        <option value="one_time" {{ old('billing_cycle') == 'one_time' ? 'selected' : '' }}>Único</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Precio sugerido y final --}}
            <div class="form-row">
                <div class="form-group">
                    <label>Precio sugerido</label>
                    <div id="precio-sugerido" class="form-input" style="background: var(--card); cursor:default;">
                        — Selecciona servicio, región, tipo y ciclo —
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount">Precio final en USD <span class="required">*</span></label>
                    <input type="number" id="amount" name="amount"
                           value="{{ old('amount') }}"
                           class="form-input @error('amount') is-invalid @enderror"
                           placeholder="0.00" step="0.01" min="0">
                    @error('amount') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-file-invoice"></i> Generar factura
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    const precios = @json(
        \App\Models\ServicePrice::all()->groupBy(fn($p) =>
            $p->service_id . '_' . $p->region . '_' . $p->client_type . '_' . $p->billing_cycle
        )->map(fn($group) => $group->first()->price)
    );

    function calcularPrecio() {
        const serviceId    = document.getElementById('service_id').value;
        const region       = document.getElementById('region').value;
        const clientType   = document.getElementById('client_type').value;
        const billingCycle = document.getElementById('billing_cycle').value;

        const key = `${serviceId}_${region}_${clientType}_${billingCycle}`;
        const precio = precios[key];

        const sugerido = document.getElementById('precio-sugerido');
        const amount   = document.getElementById('amount');

        if (precio) {
            sugerido.textContent = `$ ${parseFloat(precio).toFixed(2)} USD`;
            amount.value = parseFloat(precio).toFixed(2);
        } else {
            sugerido.textContent = '— Sin precio configurado —';
            amount.value = '';
        }
    }
</script>
@endpush