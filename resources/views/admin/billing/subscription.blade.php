@extends('layouts.admin')

@section('title', 'Configurar Suscripción')

@php $pageTitle = 'Configurar Suscripción'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Suscripción — {{ $invoice->user->name }} {{ $invoice->user->last_name ?? '' }}</p>
            <a href="{{ route('billing.show', $invoice->id) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a factura
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('billing.subscription.store', $invoice->id) }}">
            @csrf

            {{-- Servicio recurrente --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="service_id">Servicio recurrente <span class="required">*</span></label>
                    <select id="service_id" name="service_id" class="form-input">
                        <option value="">— Seleccionar —</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="billing_cycle">Ciclo <span class="required">*</span></label>
                    <select id="billing_cycle" name="billing_cycle" class="form-input">
                        <option value="">— Seleccionar —</option>
                        <option value="monthly" {{ old('billing_cycle') == 'monthly' ? 'selected' : '' }}>Mensual</option>
                        <option value="annual"  {{ old('billing_cycle') == 'annual'  ? 'selected' : '' }}>Anual</option>
                    </select>
                    @error('billing_cycle') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="amount">Precio en USD <span class="required">*</span></label>
                    <input type="number" id="amount" name="amount"
                           value="{{ old('amount') }}"
                           class="form-input @error('amount') is-invalid @enderror"
                           placeholder="0.00" step="0.01" min="0">
                    @error('amount') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="starts_at">Fecha de inicio <span class="required">*</span></label>
                    <input type="date" id="starts_at" name="starts_at"
                           value="{{ old('starts_at', now()->format('Y-m-d')) }}"
                           class="form-input @error('starts_at') is-invalid @enderror">
                    @error('starts_at') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Reunión con soporte --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="support_id">Agente de soporte <span class="required">*</span></label>
                    <select id="support_id" name="support_id" class="form-input">
                        <option value="">— Seleccionar —</option>
                        @foreach($supports as $support)
                            <option value="{{ $support->id }}" {{ old('support_id') == $support->id ? 'selected' : '' }}>
                                {{ $support->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('support_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="meeting_at">Fecha de primera reunión <span class="required">*</span></label>
                    <input type="datetime-local" id="meeting_at" name="meeting_at"
                           value="{{ old('meeting_at') }}"
                           class="form-input @error('meeting_at') is-invalid @enderror">
                    @error('meeting_at') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-check"></i> Confirmar y activar cliente
                </button>
            </div>

        </form>
    </div>

@endsection