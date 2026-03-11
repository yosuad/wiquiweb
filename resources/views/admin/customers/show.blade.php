@extends('layouts.admin')

@section('title', 'Customer — ' . $contact->first_name . ' ' . $contact->last_name)

@php $pageTitle = 'Customer'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">{{ $contact->first_name }} {{ $contact->last_name }}{{ $contact->company_name ? ' — ' . $contact->company_name : '' }}</p>
            <a href="{{ route('customers') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to customers
            </a>
        </div>
    </div>

    {{-- Contracted services --}}
    <div class="table-container" style="margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; padding: 1rem 1rem 0;">
            <i class="fas fa-box-open" style="color: var(--primary-color);"></i> Contracted services
        </h3>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Cycle</th>
                    <th>Price</th>
                    <th>Started</th>
                    <th>Status</th>
                    <th>Invoices</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contact->services as $cs)
                    <tr>
                        <td class="font-medium">{{ $cs->service->name ?? '—' }}</td>
                        <td>
                            @php
                                $cycleLabel = match($cs->billing_cycle) {
                                    'monthly'  => 'Mensual',
                                    'annual'   => 'Anual',
                                    'one_time' => 'Pago único',
                                    default    => $cs->billing_cycle
                                };
                            @endphp

                            {{ $cycleLabel }}

                            @if($cs->billing_cycle === 'monthly')
                                @php
                                    $latestInvoice = $cs->invoices->sortByDesc('created_at')->first();
                                    $mes = $latestInvoice
                                        ? \Carbon\Carbon::parse($latestInvoice->created_at)->locale('es')->translatedFormat('F Y')
                                        : \Carbon\Carbon::now()->locale('es')->translatedFormat('F Y');
                                @endphp
                                — {{ ucfirst($mes) }}
                            @elseif($cs->billing_cycle === 'annual')
                                @php
                                    $anio = $cs->started_at
                                        ? \Carbon\Carbon::parse($cs->started_at)->format('Y')
                                        : \Carbon\Carbon::now()->format('Y');
                                @endphp
                                — {{ $anio }}
                            @endif
                        </td>
                        <td>$ {{ number_format($cs->price, 2) }} {{ $cs->currency }}</td>
                        <td>{{ $cs->started_at ? \Carbon\Carbon::parse($cs->started_at)->format('Y-m-d') : '—' }}</td>
                        <td>
                            <span class="badge {{ match($cs->status) {
                                'active'    => 'badge-closed',
                                'suspended' => 'badge-follow',
                                'cancelled' => 'badge-lost',
                                default     => 'badge-new'
                            } }}">
                                {{ ucfirst($cs->status) }}
                            </span>
                        </td>
                        <td>
                            @forelse($cs->invoices as $invoice)
                                <span class="badge {{ match($invoice->status) {
                                    'pending'   => 'badge-new',
                                    'paid'      => 'badge-follow',
                                    'approved'  => 'badge-closed',
                                    'cancelled' => 'badge-lost',
                                    default     => 'badge-new'
                                } }}" style="font-size:0.65rem; margin-right: 2px;">
                                    {{ ucfirst($invoice->status) }} — ${{ number_format($invoice->amount, 2) }}
                                </span>
                            @empty
                                <span style="color: var(--text-secondary);">—</span>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No services contracted.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Add new service --}}
    <div class="form-container">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
            <i class="fas fa-plus-circle" style="color: var(--primary-color);"></i> Add service
        </h3>

        <form method="POST" action="{{ route('prospects.invoice.generate', $contact->id) }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="region">Region <span class="required">*</span></label>
                    <select id="region" name="region" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Select —</option>
                        <option value="colombia"      {{ old('region', $contact->region) == 'colombia'      ? 'selected' : '' }}>Colombia</option>
                        <option value="international" {{ old('region', $contact->region) == 'international' ? 'selected' : '' }}>International</option>
                    </select>
                    @error('region') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="client_type">Client type <span class="required">*</span></label>
                    <select id="client_type" name="client_type" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Select —</option>
                        <option value="persona_natural"     {{ old('client_type', $contact->client_type) == 'persona_natural'     ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type', $contact->client_type) == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type', $contact->client_type) == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type', $contact->client_type) == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type', $contact->client_type) == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                    @error('client_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="service_id">Service <span class="required">*</span></label>
                    <select id="service_id" name="service_id" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Select —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}"
                                {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="billing_cycle">Ciclo <span class="required">*</span></label>
                    <select id="billing_cycle" name="billing_cycle" class="form-input" onchange="calcularPrecio()">
                        <option value="">— Select —</option>
                        <option value="monthly"  {{ old('billing_cycle') == 'monthly'  ? 'selected' : '' }}>Pago mensual</option>
                        <option value="annual"   {{ old('billing_cycle') == 'annual'   ? 'selected' : '' }}>Pago anual</option>
                        <option value="one_time" {{ old('billing_cycle') == 'one_time' ? 'selected' : '' }}>Pago único</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Suggested price</label>
                    <div id="precio-sugerido" class="form-input" style="background: var(--bg-body); cursor:default; color: var(--text-secondary);">
                        — Select service, region, type and cycle —
                    </div>
                    <input type="hidden" id="service_price_id" name="service_price_id">
                </div>

                <div class="form-group">
                    <label for="amount">Final price (USD) <span class="required">*</span></label>
                    <input type="number" id="amount" name="amount"
                           value="{{ old('amount') }}"
                           class="form-input @error('amount') is-invalid @enderror"
                           placeholder="0.00" step="0.01" min="0">
                    @error('amount') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-file-invoice"></i> Generate invoice
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    const precios = @json(
        \App\Models\ServicePrice::all()->mapWithKeys(fn($p) => [
            $p->service_id . '_' . $p->region . '_' . $p->client_type . '_' . $p->billing_cycle => [
                'price' => $p->price,
                'id'    => $p->id,
            ]
        ])
    );

    function calcularPrecio() {
        const serviceId    = document.getElementById('service_id').value;
        const region       = document.getElementById('region').value;
        const clientType   = document.getElementById('client_type').value;
        const billingCycle = document.getElementById('billing_cycle').value;

        const key   = `${serviceId}_${region}_${clientType}_${billingCycle}`;
        const entry = precios[key];

        const sugerido       = document.getElementById('precio-sugerido');
        const amount         = document.getElementById('amount');
        const servicePriceId = document.getElementById('service_price_id');

        if (entry) {
            sugerido.textContent = `$ ${parseFloat(entry.price).toFixed(2)} USD`;
            amount.value         = parseFloat(entry.price).toFixed(2);
            servicePriceId.value = entry.id;
        } else {
            sugerido.textContent = '— No price configured —';
            amount.value         = '';
            servicePriceId.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', calcularPrecio);
</script>
@endpush