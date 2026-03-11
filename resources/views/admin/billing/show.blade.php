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

    {{-- Update status and payment link --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">
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
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($history as $item)
                    <tr style="{{ $item->id == $invoice->id ? 'font-weight: 600;' : '' }}">
                        <td># {{ $item->id }}</td>
                        <td>{{ $item->contactService->service->name ?? '—' }}</td>
                        <td>
                            @php $cycle = $item->contactService->billing_cycle ?? ''; @endphp
                            @if($cycle === 'monthly')
                                Mensual — {{ ucfirst($item->created_at->locale('es')->translatedFormat('F Y')) }}
                            @elseif($cycle === 'annual')
                                Anual — {{ $item->created_at->format('Y') }}
                            @elseif($cycle === 'one_time')
                                Pago único
                            @else
                                —
                            @endif
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
                        <td class="text-center">
                            <a href="{{ route('billing.invoice', $item->id) }}" target="_blank" class="btn-action btn-notes" title="Ver factura">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No invoice history.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection