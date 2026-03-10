@extends('layouts.admin')

@section('title', 'Invoice Detail')

@php $pageTitle = 'Invoice Detail'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Invoice #{{ $invoice->id }} — {{ $invoice->contactService->contact->first_name }} {{ $invoice->contactService->contact->last_name }}</p>
            <a href="{{ route('billing') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to billing
            </a>
        </div>
    </div>

    {{-- Invoice data --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">

        <div class="form-row">
            <div class="form-group">
                <label>Client</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $invoice->contactService->contact->first_name }} {{ $invoice->contactService->contact->last_name }}
                </div>
            </div>
            <div class="form-group">
                <label>Company</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $invoice->contactService->contact->company_name ?? '—' }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Service</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $invoice->contactService->service->name ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Billing cycle</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ match($invoice->contactService->billing_cycle) {
                        'monthly'  => 'Monthly',
                        'annual'   => 'Annual',
                        'one_time' => 'One time',
                        default    => $invoice->contactService->billing_cycle
                    } }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Region</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ ucfirst($invoice->contactService->servicePrice->region ?? '—') }}
                </div>
            </div>
            <div class="form-group">
                <label>Client type</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ ucfirst($invoice->contactService->servicePrice->client_type ?? '—') }}
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Amount USD</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    $ {{ number_format($invoice->amount, 2) }} USD
                </div>
            </div>
            <div class="form-group">
                <label>Amount COP</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    $ {{ number_format($invoice->amount * config('settings.usd_to_cop'), 0, ',', '.') }} COP
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Agent</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $invoice->agent->name ?? '—' }}
                </div>
            </div>
            <div class="form-group">
                <label>Date</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $invoice->created_at->format('Y-m-d') }}
                </div>
            </div>
        </div>

        {{-- Update status and payment link --}}
        @if($invoice->status !== 'cancelled')
        <form method="POST" action="{{ route('billing.update', $invoice->id) }}">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" class="form-input">
                        <option value="pending"  {{ $invoice->status == 'pending'  ? 'selected' : '' }}>Pending</option>
                        <option value="paid"     {{ $invoice->status == 'paid'     ? 'selected' : '' }}>Paid</option>
                        <option value="approved" {{ $invoice->status == 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payment_link">Payment link</label>
                    <input type="url" id="payment_link" name="payment_link"
                           value="{{ old('payment_link', $invoice->payment_link ?? '') }}"
                           class="form-input"
                           placeholder="https://...">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Save changes
                </button>
            </div>

        </form>
        @else
            <div style="padding: 1rem; background: var(--bg-danger); border-radius: var(--radius); color: var(--danger); font-weight: 600;">
                <i class="fas fa-ban"></i> This invoice has been cancelled.
            </div>
        @endif

    </div>

    {{-- Invoice history for this client --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Cycle</th>
                    <th>Amount USD</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr style="{{ $item->id == $invoice->id ? 'font-weight: 600;' : '' }}">
                        <td># {{ $item->id }}</td>
                        <td>{{ $item->contactService->service->name ?? '—' }}</td>
                        <td>
                            {{ match($item->contactService->billing_cycle ?? '') {
                                'monthly'  => 'Monthly',
                                'annual'   => 'Annual',
                                'one_time' => 'One time',
                                default    => '—'
                            } }}
                        </td>
                        <td>$ {{ number_format($item->amount, 2) }}</td>
                        <td>
                            <span class="badge {{ match($item->status) {
                                'pending'   => 'badge-new',
                                'paid'      => 'badge-contact',
                                'approved'  => 'badge-closed',
                                'cancelled' => 'badge-lost',
                                default     => 'badge-new'
                            } }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No invoice history.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection