@extends('layouts.admin')

@section('title', 'Customers')

@php $pageTitle = 'Customers'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Active customers</p>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Name</th>
                    <th>WhatsApp</th>
                    <th>Email</th>
                    <th>Services</th>
                    <th>Assigned to</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="font-medium">{{ $customer->company_name ?? '—' }}</td>
                        <td>{{ $customer->first_name }} {{ $customer->last_name }}</td>
                        <td>{{ $customer->whatsapp ?? '—' }}</td>
                        <td class="td-email">{{ $customer->email ?? '—' }}</td>
                        <td>
                            @forelse($customer->services as $cs)
                                <span class="badge badge-closed" style="margin-bottom:2px; display:inline-block;">
                                    {{ $cs->service->name ?? '—' }}
                                </span>
                            @empty
                                <span class="badge badge-lost">No services</span>
                            @endforelse
                        </td>
                        <td>{{ $customer->agent->name ?? '—' }}</td>
                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            {{-- View detail --}}
                            <a href="{{ route('customers.show', $customer->id) }}" class="btn-action btn-notes"
                                title="View detail">
                                <i data-lucide="eye"></i>
                            </a>
                            {{-- Edit customer --}}
                            <a href="{{ route('customers.edit', $customer->id) }}" class="btn-action btn-edit"
                                title="Edit">
                                <i data-lucide="pencil"></i>
                            </a>
                            {{-- Mark as lost --}}
                            <form method="POST" action="{{ route('prospects.update', $customer->id) }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="first_name" value="{{ $customer->first_name }}">
                                <input type="hidden" name="last_name" value="{{ $customer->last_name }}">
                                <input type="hidden" name="status" value="lost">
                                <input type="hidden" name="redirect_to" value="customers">
                                <button class="btn-action btn-delete" title="Mark as lost"
                                    onclick="return confirm('Mark {{ $customer->first_name }} as lost?')">
                                    <i data-lucide="user-x"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No customers registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($customers->hasPages())
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
    @endif

@endsection