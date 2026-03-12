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

    {{-- Add new service --}}
    <div class="form-container form-container--spaced">

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
                    <select id="billing_cycle" name="billing_cycle" class="form-input" onchange="calcularPrecio(); togglePeriod();">
                        <option value="">— Select —</option>
                        <option value="monthly"  {{ old('billing_cycle') == 'monthly'  ? 'selected' : '' }}>Pago mensual</option>
                        <option value="annual"   {{ old('billing_cycle') == 'annual'   ? 'selected' : '' }}>Pago anual</option>
                        <option value="one_time" {{ old('billing_cycle') == 'one_time' ? 'selected' : '' }}>Pago único</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Mes de facturación (solo monthly) --}}
            <div class="form-row" id="period-row" style="display: none;">
                <div class="form-group">
                    <label for="billing_month">Mes de facturación <span class="required">*</span></label>
                    <input type="month" id="billing_month" name="billing_month"
                           disabled
                           value="{{ old('billing_month', now()->format('Y-m')) }}"
                           class="form-input @error('billing_month') is-invalid @enderror">
                    @error('billing_month') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" id="description" name="description"
                           value="{{ old('description') }}"
                           class="form-input"
                           placeholder="Ej: Hosting página web, Hosting landing redes...">
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group"></div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Suggested price</label>
                    <div id="precio-sugerido" class="form-input form-input--readonly">
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

    {{-- Contracted services --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Cycle</th>
                    <th>Price</th>
                    <th>Started</th>
                    <th>Status</th>
                    <th>Invoices</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contact->services as $cs)
                    <tr x-data="{ editing: false, description: '{{ addslashes($cs->description ?? '') }}' }">
                        <td class="font-medium">{{ $cs->service->name ?? '—' }}</td>

                        {{-- Description — inline edit --}}
                        <td>
                            <span x-show="!editing">{{ $cs->description ?? '—' }}</span>
                            <form x-show="editing" method="POST"
                                  action="{{ route('customers.service.description', $cs->id) }}"
                                  style="display: flex; gap: 0.4rem; align-items: center;">
                                @csrf
                                @method('PATCH')
                                <input type="text" name="description" x-model="description"
                                       class="form-input"
                                       style="font-size: 0.8rem; padding: 0.3rem 0.5rem;">
                                <button type="submit" class="btn-action btn-notes" title="Save">
                                    <i class="fas fa-save"></i>
                                </button>
                                <button type="button" class="btn-action btn-delete" title="Cancel" @click="editing = false">
                                    <i class="fas fa-times"></i>
                                </button>
                            </form>
                        </td>

                        <td>
                            @if($cs->billing_cycle === 'monthly')
                                @php
                                    $latestInvoice = $cs->invoices->sortByDesc('created_at')->first();
                                    $mes = $latestInvoice?->period_start
                                        ? \Carbon\Carbon::parse($latestInvoice->period_start)->locale('es')->translatedFormat('F Y')
                                        : \Carbon\Carbon::now()->locale('es')->translatedFormat('F Y');
                                @endphp
                                Mes de {{ ucfirst($mes) }}
                            @elseif($cs->billing_cycle === 'annual')
                                Anual — {{ $cs->started_at ? \Carbon\Carbon::parse($cs->started_at)->format('Y') : \Carbon\Carbon::now()->format('Y') }}
                            @else
                                Pago único
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
                                    'courtesy'  => 'badge-follow',
                                    'cancelled' => 'badge-lost',
                                    default     => 'badge-new'
                                } }}">
                                    {{ ucfirst($invoice->status) }} — ${{ number_format($invoice->amount, 2) }}
                                </span>
                            @empty
                                <span class="text-muted">—</span>
                            @endforelse
                        </td>
                        <td class="td-actions">

                            {{-- Edit description --}}
                            <button class="btn-action btn-edit" title="Edit description" @click="editing = !editing">
                                <i class="fas fa-pen"></i>
                            </button>

                            @if($cs->status === 'active')
                                <form method="POST" action="{{ route('customers.service.status', $cs->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="suspended">
                                    <button class="btn-action btn-follow" title="Suspend service">
                                        <i class="fas fa-pause"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('customers.service.status', $cs->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn-action btn-delete" title="Cancel service"
                                        onclick="return confirm('Are you sure you want to cancel this service?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($cs->status === 'suspended')
                                <form method="POST" action="{{ route('customers.service.status', $cs->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button class="btn-action btn-notes" title="Reactivate service">
                                        <i class="fas fa-play"></i>
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('customers.service.status', $cs->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="cancelled">
                                    <button class="btn-action btn-delete" title="Cancel service"
                                        onclick="return confirm('Are you sure you want to cancel this service?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($cs->status === 'cancelled')
                                <form method="POST" action="{{ route('customers.service.status', $cs->id) }}">
                                    @csrf @method('PATCH')
                                    <input type="hidden" name="status" value="active">
                                    <button class="btn-action btn-notes" title="Reactivate service">
                                        <i class="fas fa-redo"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No services contracted.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection

@push('scripts')
<script>
    window.preciosData = @json(
        \App\Models\ServicePrice::all()->mapWithKeys(fn($p) => [
            $p->service_id . '_' . $p->region . '_' . $p->client_type . '_' . $p->billing_cycle => [
                'price' => $p->price,
                'id'    => $p->id,
            ]
        ])
    );
</script>
@endpush