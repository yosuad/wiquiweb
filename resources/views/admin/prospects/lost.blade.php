@extends('layouts.admin')

@section('title', 'Lost Prospects')

@php $pageTitle = 'Lost Prospects'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Leads that did not convert</p>
            <a href="{{ route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> View active
            </a>
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
                    <th>Origin</th>
                    <th>Service interest</th>
                    <th>Date</th>
                    <th>Assigned to</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects as $prospect)
                    <tr>
                        <td class="font-medium">{{ $prospect->company_name ?? '—' }}</td>
                        <td>{{ $prospect->first_name }} {{ $prospect->last_name }}</td>
                        <td>{{ $prospect->whatsapp ?? '—' }}</td>
                        <td class="td-email">{{ $prospect->email ?? '—' }}</td>
                        <td>{{ ucfirst($prospect->origin ?? '—') }}</td>
                        <td>{{ $prospect->service_interest ?? '—' }}</td>
                        <td>{{ $prospect->created_at->format('Y-m-d') }}</td>
                        <td>{{ $prospect->agent->name ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('prospects.notes.index', $prospect->id) }}?from=lost"
                                class="btn-action btn-notes" title="View notes">
                                <i class="fas fa-clipboard-list"></i>
                            </a>
                        </td>
                        <td class="td-actions">
                            <a href="{{ route('prospects.edit', $prospect->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            @can('delete prospects')
                                <form method="POST" action="{{ route('prospects.destroy', $prospect->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="redirect_to" value="prospects.lost">
                                    <button class="btn-action btn-delete" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No lost prospects registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($prospects->hasPages())
        <div class="pagination-wrapper">
            {{ $prospects->links() }}
        </div>
    @endif

@endsection