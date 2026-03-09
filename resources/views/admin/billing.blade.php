@extends('layouts.admin')

@section('title', 'Facturación')

@php $pageTitle = 'Facturación'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Gestión de facturas</p>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Servicio</th>
                    <th>Ciclo</th>
                    <th>Monto USD</th>
                    <th>Monto COP</th>
                    <th>Estado</th>
                    <th>Agente</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="font-medium">{{ $invoice->user->name ?? '—' }} {{ $invoice->user->last_name ?? '' }}</td>
                        <td>{{ $invoice->service->name ?? '—' }}</td>
                        <td>
                            {{ match($invoice->billing_cycle) {
                                'monthly'  => 'Mensual',
                                'annual'   => 'Anual',
                                'one_time' => 'Único',
                                default    => $invoice->billing_cycle
                            } }}
                        </td>
                        <td class="font-medium">$ {{ number_format($invoice->amount, 2) }}</td>
                        <td>$ {{ number_format($invoice->amount * config('settings.usd_to_cop'), 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ match($invoice->status) {
                                'pendiente'      => 'badge-new',
                                'pagado'         => 'badge-contact',
                                'aprobado'       => 'badge-closed',
                                'implementacion' => 'badge-follow',
                                default          => 'badge-new'
                            } }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>{{ $invoice->agent->name ?? '—' }}</td>
                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('billing.show', $invoice->id) }}" class="btn-action btn-notes" title="Ver detalle">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('billing.destroy', $invoice->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay facturas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection