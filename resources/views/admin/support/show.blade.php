@extends('layouts.admin')

@section('title', 'Ticket #' . $ticket->id)

@php $pageTitle = 'Support'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">
                Ticket #{{ $ticket->id }} — {{ $ticket->contact->company_name ?? $ticket->contact->first_name . ' ' . $ticket->contact->last_name }}
            </p>
            <a href="{{ route('support') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to support
            </a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 320px; gap: 1.5rem; align-items: start;">

        {{-- Left: ticket detail + notes --}}
        <div>

            {{-- Info card --}}
            <div class="form-container form-container--spaced" style="margin-bottom: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div>
                        <h2 style="font-size: 1.1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 0.25rem;">
                            {{ $ticket->subject }}
                        </h2>
                        <span style="font-size: 0.8rem; color: var(--text-secondary);">
                            Created by {{ $ticket->creator->name ?? '—' }} — {{ $ticket->created_at->format('Y-m-d H:i') }}
                        </span>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <span class="badge {{ match($ticket->priority) {
                            'high'   => 'badge-lost',
                            'medium' => 'badge-follow',
                            'low'    => 'badge-new',
                            default  => 'badge-new'
                        } }}">{{ ucfirst($ticket->priority) }}</span>
                        <span class="badge {{ match($ticket->status) {
                            'open'        => 'badge-new',
                            'in_progress' => 'badge-follow',
                            'resolved'    => 'badge-contact',
                            'closed'      => 'badge-closed',
                            default       => 'badge-new'
                        } }}">{{ match($ticket->status) {
                            'open'        => 'Open',
                            'in_progress' => 'In progress',
                            'resolved'    => 'Resolved',
                            'closed'      => 'Closed',
                            default       => ucfirst($ticket->status)
                        } }}</span>
                    </div>
                </div>

                @if($ticket->description)
                    <div style="background: var(--bg-body); border-radius: var(--radius); padding: 1rem; font-size: 0.9rem; color: var(--text-primary); line-height: 1.6; white-space: pre-wrap;">{{ $ticket->description }}</div>
                @else
                    <p class="text-muted" style="font-size: 0.875rem;">No description provided.</p>
                @endif
            </div>

            {{-- Notes timeline --}}
            <div class="form-container form-container--spaced">
                <p style="font-weight: 700; font-size: 0.9rem; margin-bottom: 1.25rem; color: var(--text-primary);">
                    <i class="fas fa-comments"></i> Follow-up notes
                </p>

                @forelse($ticket->notes as $note)
                    <div style="display: flex; gap: 0.75rem; margin-bottom: 1.25rem;">
                        <div style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-color); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 0.8rem; flex-shrink: 0;">
                            {{ strtoupper(substr($note->creator->name ?? 'A', 0, 1)) }}
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.25rem;">
                                <span style="font-weight: 600; font-size: 0.85rem; color: var(--text-primary);">{{ $note->creator->name ?? '—' }}</span>
                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="font-size: 0.75rem; color: var(--text-secondary);">{{ $note->created_at->format('Y-m-d H:i') }}</span>
                                    <form method="POST" action="{{ route('support.notes.destroy', [$ticket->id, $note->id]) }}"
                                        data-confirm="¿Eliminar esta nota?">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete" title="Delete note" style="padding: 0.2rem 0.4rem; font-size: 0.7rem;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <div style="background: var(--bg-body); border-radius: var(--radius); padding: 0.75rem 1rem; font-size: 0.875rem; color: var(--text-primary); line-height: 1.6; white-space: pre-wrap;">{{ $note->note }}</div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted" style="font-size: 0.875rem; margin-bottom: 1.25rem;">No notes yet.</p>
                @endforelse

                {{-- Add note form --}}
                <form method="POST" action="{{ route('support.notes.store', $ticket->id) }}" style="border-top: 1px solid var(--border); padding-top: 1.25rem; margin-top: 0.5rem;">
                    @csrf
                    <div class="form-group" style="margin-bottom: 0.75rem;">
                        <label for="note">Add note</label>
                        <textarea id="note" name="note"
                                  class="form-input @error('note') is-invalid @enderror"
                                  rows="3"
                                  placeholder="Write a follow-up note...">{{ old('note') }}</textarea>
                        @error('note') <span class="form-error">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane"></i> Add note
                    </button>
                </form>
            </div>

        </div>

        {{-- Right: update form --}}
        <div class="form-container">
            <p style="font-weight: 700; font-size: 0.9rem; margin-bottom: 1rem; color: var(--text-primary);">
                <i class="fas fa-sliders-h"></i> Update ticket
            </p>

            <form method="POST" action="{{ route('support.update', $ticket->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="status">Status <span class="required">*</span></label>
                    <select id="status" name="status" class="form-input">
                        <option value="open"        {{ $ticket->status == 'open'        ? 'selected' : '' }}>Open</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In progress</option>
                        <option value="resolved"    {{ $ticket->status == 'resolved'    ? 'selected' : '' }}>Resolved</option>
                        <option value="closed"      {{ $ticket->status == 'closed'      ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="priority">Priority <span class="required">*</span></label>
                    <select id="priority" name="priority" class="form-input">
                        <option value="high"   {{ $ticket->priority == 'high'   ? 'selected' : '' }}>High</option>
                        <option value="medium" {{ $ticket->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="low"    {{ $ticket->priority == 'low'    ? 'selected' : '' }}>Low</option>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="assigned_to">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="">— Select agent —</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ $ticket->assigned_to == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 1rem;">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              class="form-input"
                              rows="4">{{ old('description', $ticket->description) }}</textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%;">
                    <i class="fas fa-save"></i> Save changes
                </button>

            </form>

            {{-- Delete --}}
            <form method="POST" action="{{ route('support.destroy', $ticket->id) }}"
                data-confirm="¿Eliminar el ticket #{{ $ticket->id }}? Esta acción no se puede deshacer."
                style="margin-top: 0.75rem;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-secondary" style="width: 100%; color: var(--danger); border-color: var(--danger);">
                    <i class="fas fa-trash"></i> Delete ticket
                </button>
            </form>

            {{-- Client info --}}
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border);">
                <p style="font-weight: 700; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--text-secondary); margin-bottom: 0.75rem;">Client</p>
                <p style="font-weight: 600; font-size: 0.9rem; color: var(--text-primary);">
                    {{ $ticket->contact->company_name ?? $ticket->contact->first_name . ' ' . $ticket->contact->last_name }}
                </p>
                @if($ticket->contact->email)
                    <p style="font-size: 0.8rem; color: var(--text-secondary);">{{ $ticket->contact->email }}</p>
                @endif
                @if($ticket->contact->whatsapp)
                    <p style="font-size: 0.8rem; color: var(--text-secondary);">{{ $ticket->contact->whatsapp }}</p>
                @endif
                <a href="{{ route('customers.show', $ticket->contact->id) }}" class="btn-secondary" style="margin-top: 0.75rem; display: inline-flex; font-size: 0.8rem;">
                    <i class="fas fa-user"></i> View customer
                </a>
            </div>

        </div>
    </div>

@endsection