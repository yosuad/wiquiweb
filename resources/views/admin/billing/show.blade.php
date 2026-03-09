@extends('layouts.admin')

@section('title', 'Detalle de Factura')

@php $pageTitle = 'Detalle de Factura'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Factura #{{ $invoice->id }} — {{ $invoice->user->name }} {{ $invoice->user->last_name ?? '' }}</p>
            <a href="{{ route('billing') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a facturación
            </a>
        </div>
    </div>

    {{-- Datos de la factura --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">

        <div class="form-row">
            <div class="form-group">
                <label>Cliente</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ $invoice->user->name }} {{ $invoice->user->last_name ?? '' }}
                </div>
            </div>
            <div class="form-group">
                <label>Empresa</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ $invoice->user->company ?? '—' }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Servicio</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ $invoice->service->name ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Ciclo</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ match($invoice->billing_cycle) {
                        'monthly'  => 'Mensual',
                        'annual'   => 'Anual',
                        'one_time' => 'Único',
                        default    => $invoice->billing_cycle
                    } }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Región</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ ucfirst($invoice->region) }}
                </div>
            </div>
            <div class="form-group">
                <label>Tipo de cliente</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ ucfirst(str_replace('_', ' ', $invoice->client_type)) }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Monto USD</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    $ {{ number_format($invoice->amount, 2) }} USD
                </div>
            </div>
            <div class="form-group">
                <label>Monto COP</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    $ {{ number_format($invoice->amount * config('settings.usd_to_cop'), 0, ',', '.') }} COP
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Agente</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ $invoice->agent->name ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Fecha</label>
                <div class="form-input" style="background: var(--card); cursor:default;">
                    {{ $invoice->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>

        {{-- Cambiar estado y link de pago --}}
        <form method="POST" action="{{ route('billing.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Estado <span class="required">*</span></label>
                    <select id="status" name="status" class="form-input">
                        <option value="pendiente" {{ $invoice->status == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado"    {{ $invoice->status == 'pagado'    ? 'selected' : '' }}>Pagado</option>
                        <option value="aprobado"  {{ $invoice->status == 'aprobado'  ? 'selected' : '' }}>Aprobado</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_link">Link de pago</label>
                    <input type="url" id="payment_link" name="payment_link"
                           value="{{ old('payment_link', $invoice->payment_link ?? '') }}"
                           class="form-input"
                           placeholder="https://...">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar cambios
                </button>
            </div>

        </form>
    </div>

    {{-- Historial de facturas del cliente --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Servicio</th>
                    <th>Ciclo</th>
                    <th>Monto USD</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr style="{{ $item->id == $invoice->id ? 'font-weight: 600;' : '' }}">
                        <td># {{ $item->id }}</td>
                        <td>{{ $item->service->name ?? '—' }}</td>
                        <td>
                            {{ match($item->billing_cycle) {
                                'monthly'  => 'Mensual',
                                'annual'   => 'Anual',
                                'one_time' => 'Único',
                                default    => $item->billing_cycle
                            } }}
                        </td>
                        <td>$ {{ number_format($item->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ match($item->status) {
                                'pendiente' => 'badge-new',
                                'pagado'    => 'badge-contact',
                                'aprobado'  => 'badge-closed',
                                default     => 'badge-new'
                            } }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay historial.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection