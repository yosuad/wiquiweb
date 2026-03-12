@extends('layouts.admin')

@section('title', 'Invoices — ' . $contact->first_name . ' ' . $contact->last_name)

@php $pageTitle = 'Invoice Detail'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">{{ $contact->first_name }}
                {{ $contact->last_name }}{{ $contact->company_name ? ' — ' . $contact->company_name : '' }}</p>
            <a href="{{ route('billing') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to billing
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Service</th>
                    <th>Description</th>
                    <th>Cycle</th>
                    <th>Amount USD</th>
                    <th>Payment link</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $item)
                    <tr>
                        <td># {{ $item->id }}</td>
                        <td>{{ $item->contactService->service->name ?? '—' }}</td>
                        <td>{{ $item->contactService->description ?? '—' }}</td>
                        <td>
                            @php $cycle = $item->contactService->billing_cycle ?? ''; @endphp
                            @if ($cycle === 'monthly')
                                Mes de
                                {{ ucfirst($item->period_start ? \Carbon\Carbon::parse($item->period_start)->locale('es')->translatedFormat('F Y') : $item->created_at->locale('es')->translatedFormat('F Y')) }}
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
                            {{-- Payment link inline form --}}
                            @if ($item->status === 'pending')
                                <form method="POST" action="{{ route('billing.update', $item->id) }}"
                                    style="display:flex; gap: 0.5rem; align-items: center;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $item->status }}">
                                    <input type="url" name="payment_link" value="{{ $item->payment_link ?? '' }}"
                                        class="form-input" placeholder="https://..."
                                        style="font-size: 0.75rem; padding: 0.3rem 0.5rem;">
                                    <button type="submit" class="btn-action btn-notes" title="Save link">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                            @elseif($item->payment_link)
                                <a href="{{ $item->payment_link }}" target="_blank" class="text-muted"
                                    style="font-size: 0.75rem;">
                                    <i class="fas fa-link"></i> Link
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span
                                class="badge {{ match ($item->status) {
                                    'pending' => 'badge-new',
                                    'paid' => 'badge-contact',
                                    'approved' => 'badge-closed',
                                    'courtesy' => 'badge-follow',
                                    'cancelled' => 'badge-lost',
                                    default => 'badge-new',
                                } }}">
                                {{ match ($item->status) {
                                    'pending' => 'Pending',
                                    'paid' => 'Paid',
                                    'approved' => 'Approved',
                                    'courtesy' => 'Courtesy',
                                    'cancelled' => 'Cancelled',
                                    default => ucfirst($item->status),
                                } }}
                            </span>
                        </td>
                        <td>{{ $item->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            {{-- Status action buttons --}}
                            @if ($item->status === 'pending')
                                {{-- Mark as paid --}}
                                <form method="POST" action="{{ route('billing.update', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="paid">
                                    <input type="hidden" name="payment_link" value="{{ $item->payment_link }}">
                                    <button class="btn-action btn-notes" title="Mark as paid">
                                        <i class="fas fa-dollar-sign"></i>
                                    </button>
                                </form>
                                {{-- Mark as courtesy --}}
                                <form method="POST" action="{{ route('billing.update', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="courtesy">
                                    <input type="hidden" name="payment_link" value="{{ $item->payment_link }}">
                                    <button class="btn-action btn-follow" title="Mark as courtesy">
                                        <i class="fas fa-gift"></i>
                                    </button>
                                </form>
                                {{-- Cancel --}}
                                <form method="POST" action="{{ route('billing.update', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <input type="hidden" name="payment_link" value="{{ $item->payment_link }}">
                                    <button class="btn-action btn-delete" title="Cancel invoice"
                                        onclick="return confirm('Cancel this invoice?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @elseif($item->status === 'paid')
                                {{-- Approve --}}
                                <form method="POST" action="{{ route('billing.update', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="approved">
                                    <input type="hidden" name="payment_link" value="{{ $item->payment_link }}">
                                    <button class="btn-action btn-closed" title="Approve invoice">
                                        <i class="fas fa-check-double"></i>
                                    </button>
                                </form>
                                {{-- Cancel --}}
                                <form method="POST" action="{{ route('billing.update', $item->id) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="cancelled">
                                    <input type="hidden" name="payment_link" value="{{ $item->payment_link }}">
                                    <button class="btn-action btn-delete" title="Cancel invoice"
                                        onclick="return confirm('Cancel this invoice?')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            @endif

                            {{-- View invoice --}}
                            <a href="{{ route('billing.invoice', $item->id) }}" class="btn-action btn-notes"
                                title="View invoice">
                                <i class="fas fa-eye"></i>
                            </a>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('billing.destroy', $item->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete"
                                    onclick="return confirm('Delete this invoice?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No invoices found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
