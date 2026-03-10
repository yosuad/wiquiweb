@extends('layouts.admin')

@section('title', 'Prices — ' . $service->name)

@php $pageTitle = 'Prices'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Prices for {{ $service->name }}</p>
            <a href="{{ route('services.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to services
            </a>
        </div>
    </div>

    {{-- Add price form --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">
        <form method="POST" action="{{ route('services.prices.store', $service->id) }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="region">Region <span class="required">*</span></label>
                    <select id="region" name="region" class="form-input">
                        <option value="">— Select —</option>
                        <option value="colombia"      {{ old('region') == 'colombia'      ? 'selected' : '' }}>Colombia</option>
                        <option value="international" {{ old('region') == 'international' ? 'selected' : '' }}>International</option>
                    </select>
                    @error('region') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="client_type">Client type <span class="required">*</span></label>
                    <select id="client_type" name="client_type" class="form-input">
                        <option value="">— Select —</option>
                        <option value="persona_natural"     {{ old('client_type') == 'persona_natural'     ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type') == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type') == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type') == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type') == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                    @error('client_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="billing_cycle">Billing cycle <span class="required">*</span></label>
                    <select id="billing_cycle" name="billing_cycle" class="form-input">
                        <option value="">— Select —</option>
                        <option value="monthly"  {{ old('billing_cycle') == 'monthly'  ? 'selected' : '' }}>Monthly</option>
                        <option value="annual"   {{ old('billing_cycle') == 'annual'   ? 'selected' : '' }}>Annual</option>
                        <option value="one_time" {{ old('billing_cycle') == 'one_time' ? 'selected' : '' }}>One time</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price (USD) <span class="required">*</span></label>
                    <input type="number" id="price" name="price"
                           value="{{ old('price') }}"
                           class="form-input @error('price') is-invalid @enderror"
                           placeholder="0.00" step="0.01" min="0">
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="plan">Plan (optional)</label>
                    <input type="text" id="plan" name="plan"
                           value="{{ old('plan') }}"
                           class="form-input"
                           placeholder="e.g. Basic, Pro, Enterprise">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Add price
                </button>
            </div>

        </form>
    </div>

    {{-- Prices table --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Region</th>
                    <th>Client type</th>
                    <th>Cycle</th>
                    <th>Plan</th>
                    <th>USD</th>
                    <th>COP</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prices as $price)
                    <tr>
                        <td>{{ ucfirst($price->region) }}</td>
                        <td>{{ ucfirst($price->client_type) }}</td>
                        <td>
                            {{ match($price->billing_cycle) {
                                'monthly'  => 'Monthly',
                                'annual'   => 'Annual',
                                'one_time' => 'One time',
                                default    => $price->billing_cycle
                            } }}
                        </td>
                        <td>{{ $price->plan ?? '—' }}</td>
                        <td class="font-medium">$ {{ number_format($price->price, 2) }}</td>
                        <td>$ {{ number_format($price->price * config('settings.usd_to_cop'), 0, ',', '.') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('services.prices.edit', [$service->id, $price->id]) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('services.prices.destroy', [$service->id, $price->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No prices registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection