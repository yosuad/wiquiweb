@extends('layouts.admin')

@section('title', 'Factura #{{ str_pad($invoice->id, 4, "0", STR_PAD_LEFT) }}')

@php $pageTitle = 'Factura'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Factura #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }} — {{ $invoice->contactService->contact->first_name }} {{ $invoice->contactService->contact->last_name }}</p>
            <div style="display:flex; gap: 0.75rem;">
                <a href="{{ route('billing.show', $invoice->id) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <button class="btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir / PDF
                </button>
            </div>
        </div>
    </div>

    <div class="invoice">

        {{-- Header --}}
        <div class="invoice__header">
            <div class="invoice__brand">
                <h1 class="invoice__brand-name">wiquiweb</h1>
                <span class="invoice__brand-info">facturacion@wiquiweb.com</span>
                <span class="invoice__brand-info">wiquiweb.com</span>
                <span class="invoice__brand-info">+57 320 5864135</span>
            </div>
            <div class="invoice__meta">
                <p class="invoice__meta-number">Factura #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }}</p>
                <span class="invoice__meta-date">Fecha: {{ $invoice->created_at->format('d/m/Y') }}</span>
                @if($invoice->paid_at)
                    <span class="invoice__meta-date">Pagado: {{ \Carbon\Carbon::parse($invoice->paid_at)->format('d/m/Y') }}</span>
                @endif
                <span class="invoice__status invoice__status--{{ $invoice->status }}">
                    {{ match($invoice->status) {
                        'pending'   => 'Pendiente',
                        'paid'      => 'Pagado',
                        'approved'  => 'Aprobado',
                        'cancelled' => 'Cancelado',
                        default     => ucfirst($invoice->status)
                    } }}
                </span>
            </div>
        </div>

        {{-- Body --}}
        <div class="invoice__body">

            {{-- Parties --}}
            <div class="invoice__parties">
                <div class="invoice__party">
                    <span class="invoice__party-label">Facturado por</span>
                    <p class="invoice__party-name">Wiquiweb</p>
                    <span class="invoice__party-info">facturacion@wiquiweb.com</span>
                    <span class="invoice__party-info">wiquiweb.com</span>
                    <span class="invoice__party-info">+57 320 5864135</span>
                </div>
                <div class="invoice__party invoice__party--right">
                    <span class="invoice__party-label">Facturado a</span>
                    <p class="invoice__party-name">
                        {{ $invoice->contactService->contact->company_name ?? $invoice->contactService->contact->first_name . ' ' . $invoice->contactService->contact->last_name }}
                    </p>
                    <span class="invoice__party-info">{{ $invoice->contactService->contact->first_name }} {{ $invoice->contactService->contact->last_name }}</span>
                    @if($invoice->contactService->contact->email)
                        <span class="invoice__party-info">{{ $invoice->contactService->contact->email }}</span>
                    @endif
                    @if($invoice->contactService->contact->whatsapp)
                        <span class="invoice__party-info">{{ $invoice->contactService->contact->whatsapp }}</span>
                    @endif
                </div>
            </div>

            <hr class="invoice__divider">

            {{-- Period (monthly only) --}}
            @if($invoice->contactService->billing_cycle === 'monthly' && $invoice->period_start && $invoice->period_end)
                <div class="invoice__period">
                    <i class="fas fa-calendar-alt"></i> Período:
                    {{ \Carbon\Carbon::parse($invoice->period_start)->translatedFormat('d \d\e F \d\e Y') }}
                    al
                    {{ \Carbon\Carbon::parse($invoice->period_end)->translatedFormat('d \d\e F \d\e Y') }}
                </div>
            @endif

            {{-- Service table --}}
            <table class="invoice__table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Descripción</th>
                        <th>Ciclo</th>
                        <th>Región</th>
                        <th class="invoice__table--right">Valor USD</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-semibold">{{ $invoice->contactService->service->name ?? '—' }}</td>
                        <td>{{ $invoice->contactService->description ?? '—' }}</td>
                        <td>
                            @php $cycle = $invoice->contactService->billing_cycle ?? ''; @endphp
                            @if($cycle === 'monthly')
                                Mes de {{ ucfirst($invoice->period_start ? \Carbon\Carbon::parse($invoice->period_start)->locale('es')->translatedFormat('F Y') : $invoice->created_at->locale('es')->translatedFormat('F Y')) }}
                            @elseif($cycle === 'annual')
                                Anual — {{ $invoice->created_at->format('Y') }}
                            @elseif($cycle === 'one_time')
                                Pago único
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ ucfirst($invoice->contactService->servicePrice->region ?? '—') }}</td>
                        <td class="invoice__table--right">$ {{ number_format($invoice->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Totals --}}
            <div class="invoice__totals">
                <div class="invoice__totals-box">
                    <div class="invoice__totals-row">
                        <span>Subtotal USD</span>
                        <span>$ {{ number_format($invoice->amount, 2) }}</span>
                    </div>
                    <div class="invoice__totals-row">
                        <span>Equivalente COP</span>
                        <span>$ {{ number_format($invoice->amount * config('settings.usd_to_cop'), 0, ',', '.') }}</span>
                    </div>
                    <div class="invoice__totals-row invoice__totals-row--total">
                        <span>Total</span>
                        <span>$ {{ number_format($invoice->amount, 2) }} USD</span>
                    </div>
                </div>
            </div>

            {{-- Payment link --}}
            @if($invoice->payment_link)
                <div class="invoice__payment-link">
                    <span class="invoice__payment-link-label">Enlace de pago</span>
                    <a href="{{ $invoice->payment_link }}" class="invoice__payment-link-url">
                        {{ $invoice->payment_link }}
                    </a>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="invoice__footer">
            <span>wiquiweb.com</span>
            <span>Factura #{{ str_pad($invoice->id, 4, '0', STR_PAD_LEFT) }} — {{ $invoice->created_at->format('d/m/Y') }}</span>
            <span>facturacion@wiquiweb.com</span>
        </div>

    </div>

@endsection