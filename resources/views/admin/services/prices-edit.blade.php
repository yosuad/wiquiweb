@extends('layouts.admin')

@section('title', 'Editar Precio')

@php $pageTitle = 'Editar Precio'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Editar precio — {{ $service->name }}</p>
            <a href="{{ route('services.prices', $service->id) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a precios
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('services.prices.update', [$service->id, $price->id]) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="region">Región <span class="required">*</span></label>
                    <select id="region" name="region" class="form-input">
                        <option value="">— Seleccionar —</option>
                        <option value="colombia"      {{ old('region', $price->region) == 'colombia'      ? 'selected' : '' }}>Colombia</option>
                        <option value="international" {{ old('region', $price->region) == 'international' ? 'selected' : '' }}>Internacional</option>
                    </select>
                    @error('region') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="client_type">Tipo de cliente <span class="required">*</span></label>
                    <select id="client_type" name="client_type" class="form-input">
                        <option value="">— Seleccionar —</option>
                        <option value="persona_natural"     {{ old('client_type', $price->client_type) == 'persona_natural'     ? 'selected' : '' }}>Persona natural</option>
                        <option value="empresa"             {{ old('client_type', $price->client_type) == 'empresa'             ? 'selected' : '' }}>Empresa</option>
                        <option value="emprendimiento"      {{ old('client_type', $price->client_type) == 'emprendimiento'      ? 'selected' : '' }}>Emprendimiento</option>
                        <option value="artista"             {{ old('client_type', $price->client_type) == 'artista'             ? 'selected' : '' }}>Artista</option>
                        <option value="organizacion_social" {{ old('client_type', $price->client_type) == 'organizacion_social' ? 'selected' : '' }}>Organización social</option>
                    </select>
                    @error('client_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="billing_cycle">Ciclo <span class="required">*</span></label>
                    <select id="billing_cycle" name="billing_cycle" class="form-input">
                        <option value="">— Seleccionar —</option>
                        <option value="monthly"  {{ old('billing_cycle', $price->billing_cycle) == 'monthly'  ? 'selected' : '' }}>Pago mensual</option>
                        <option value="annual"   {{ old('billing_cycle', $price->billing_cycle) == 'annual'   ? 'selected' : '' }}>Pago anual</option>
                        <option value="one_time" {{ old('billing_cycle', $price->billing_cycle) == 'one_time' ? 'selected' : '' }}>Pago único</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="price">Precio en USD <span class="required">*</span></label>
                    <input type="number" id="price" name="price"
                           value="{{ old('price', $price->price) }}"
                           class="form-input @error('price') is-invalid @enderror"
                           placeholder="0.00" step="0.01" min="0">
                    @error('price') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="plan">Plan (opcional)</label>
                    <input type="text" id="plan" name="plan"
                           value="{{ old('plan', $price->plan) }}"
                           class="form-input"
                           placeholder="Ej: Básico, Pro, Empresarial">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar precio
                </button>
            </div>

        </form>
    </div>

@endsection