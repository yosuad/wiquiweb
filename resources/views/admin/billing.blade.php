@extends('layouts.admin')

@section('title', 'Billing')

@php $pageTitle = 'Billing'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Invoice management</p>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Cycle</th>
                    <th>USD</th>
                    <th>COP</th>
                    <th>Status</th>
                    <th>Agent</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td class="font-medium">
                            {{ $invoice->contactService->contact->company_name ?? $invoice->contactService->contact->first_name . ' ' . $invoice->contactService->contact->last_name ?? '—' }}
                        </td>
                        <td>{{ $invoice->contactService->service->name ?? '—' }}</td>
                        <td>
                            {{ match($invoice->contactService->billing_cycle ?? '') {
                                'monthly'  => 'Monthly',
                                'annual'   => 'Annual',
                                'one_time' => 'One time',
                                default    => '—'
                            } }}
                        </td>
                        <td class="font-medium">$ {{ number_format($invoice->amount, 2) }}</td>
                        <td>$ {{ number_format($invoice->amount * config('settings.usd_to_cop'), 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ match($invoice->status) {
                                'pending'   => 'badge-new',
                                'paid'      => 'badge-contact',
                                'approved'  => 'badge-closed',
                                'cancelled' => 'badge-lost',
                                default     => 'badge-new'
                            } }}">
                                {{ ucfirst($invoice->status) }}
                            </span>
                        </td>
                        <td>{{ $invoice->agent->name ?? '—' }}</td>
                        <td>{{ $invoice->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('billing.show', $invoice->id) }}" class="btn-action btn-notes" title="View detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('billing.destroy', $invoice->id) }}">
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
                        <td colspan="9" class="text-center">No invoices registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection