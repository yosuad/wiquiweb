@extends('layouts.admin')

@section('title', 'Support')

@php $pageTitle = 'Support'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Support tickets</p>
            <a href="{{ route('support.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> New ticket
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="form-container form-container--spaced">
        <form method="GET" action="{{ route('support') }}">
            <div class="form-row">
                <div class="form-group">
                    <label for="search">Search</label>
                    <input type="text" id="search" name="search"
                           value="{{ $search ?? '' }}"
                           class="form-input"
                           placeholder="Subject or client...">
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="">— All —</option>
                        <option value="open"        {{ ($status ?? '') == 'open'        ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ ($status ?? '') == 'in_progress' ? 'selected' : '' }}>In progress</option>
                        <option value="resolved"    {{ ($status ?? '') == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                        <option value="closed"      {{ ($status ?? '') == 'closed'      ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select id="priority" name="priority" class="form-input">
                        <option value="">— All —</option>
                        <option value="high"   {{ ($priority ?? '') == 'high'   ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ ($priority ?? '') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low"    {{ ($priority ?? '') == 'low'    ? 'selected' : '' }}>Low</option>
                    </select>
                </div>
                <div class="form-group" style="justify-content: flex-end; align-items: flex-end; display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    @if($search || $status || $priority)
                        <a href="{{ route('support') }}" class="btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Tickets table --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Subject</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Assigned to</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tickets as $ticket)
                    <tr>
                        <td># {{ $ticket->id }}</td>
                        <td class="font-medium">
                            {{ $ticket->contact->company_name ?? $ticket->contact->first_name . ' ' . $ticket->contact->last_name }}
                        </td>
                        <td>{{ $ticket->subject }}</td>
                        <td>
                            <span class="badge {{ match($ticket->priority) {
                                'high'   => 'badge-lost',
                                'medium' => 'badge-follow',
                                'low'    => 'badge-new',
                                default  => 'badge-new'
                            } }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ match($ticket->status) {
                                'open'        => 'badge-new',
                                'in_progress' => 'badge-follow',
                                'resolved'    => 'badge-contact',
                                'closed'      => 'badge-closed',
                                default       => 'badge-new'
                            } }}">
                                {{ match($ticket->status) {
                                    'open'        => 'Open',
                                    'in_progress' => 'In progress',
                                    'resolved'    => 'Resolved',
                                    'closed'      => 'Closed',
                                    default       => ucfirst($ticket->status)
                                } }}
                            </span>
                        </td>
                        <td>{{ $ticket->agent->name ?? '—' }}</td>
                        <td>{{ $ticket->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            <a href="{{ route('support.show', $ticket->id) }}" class="btn-action btn-notes" title="View ticket">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('support.destroy', $ticket->id) }}">
                                @csrf @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete"
                                    onclick="return confirm('Delete this ticket?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">No tickets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        @if($tickets->hasPages())
            <div style="padding: 1rem;">
                {{ $tickets->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection