@extends('layouts.admin')

@section('title', 'Billing')

@php $pageTitle = 'Billing'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Invoice management</p>
        </div>
    </div>

    {{-- Search --}}
    <div class="form-container form-container--spaced">
        <form method="GET" action="{{ route('billing') }}">
            <div class="form-row">
                <div class="form-group">
                    <label for="search">Search client</label>
                    <input type="text" id="search" name="search"
                           value="{{ $search ?? '' }}"
                           class="form-input"
                           placeholder="Name or company...">
                </div>
                <div class="form-group" style="justify-content: flex-end; align-items: flex-end; display: flex;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i> Search
                    </button>
                    @if($search)
                        <a href="{{ route('billing') }}" class="btn-secondary" style="margin-left: 0.5rem;">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Clients table --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>Last invoice</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($contacts as $contact)
                    @php
                        $lastInvoice = $contact->services->flatMap->invoices->sortByDesc('created_at')->first();
                    @endphp
                    <tr>
                        <td class="font-medium">
                            {{ $contact->company_name ?? $contact->first_name . ' ' . $contact->last_name }}
                        </td>
                        <td>
                            @if($lastInvoice)
                                {{ $lastInvoice->contactService->service->name ?? '—' }}
                                @if($lastInvoice->contactService->description)
                                    <span class="text-muted"> — {{ $lastInvoice->contactService->description }}</span>
                                @endif
                            @else
                                —
                            @endif
                        </td>
                        <td class="font-medium">
                            {{ $lastInvoice ? '$ ' . number_format($lastInvoice->amount, 2) : '—' }}
                        </td>
                        <td>
                            @if($lastInvoice)
                                <span class="badge {{ match($lastInvoice->status) {
                                    'pending'   => 'badge-new',
                                    'paid'      => 'badge-contact',
                                    'approved'  => 'badge-closed',
                                    'cancelled' => 'badge-lost',
                                    default     => 'badge-new'
                                } }}">
                                    {{ ucfirst($lastInvoice->status) }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                        <td>{{ $lastInvoice ? $lastInvoice->created_at->format('Y-m-d') : '—' }}</td>
                        <td class="td-actions">
                            <a href="{{ route('billing.show', $contact->id) }}" class="btn-action btn-notes" title="View invoices">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No clients with invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection