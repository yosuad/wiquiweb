@extends('layouts.admin')

@section('title', 'Contact Notes')

@php $pageTitle = 'Notes'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Follow-up history — {{ $contact->first_name }} {{ $contact->last_name }}</p>
            <a href="{{ $from === 'lost' ? route('prospects.lost') : route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    {{-- Add note form --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">
        <form method="POST" action="{{ route('prospects.notes.store', $contact->id) }}">
            @csrf
            <input type="hidden" name="from" value="{{ $from }}">
            <div class="form-group">
                <label for="note">New note</label>
                <textarea id="note" name="note" rows="3"
                          class="form-input @error('note') is-invalid @enderror"
                          placeholder="Write a follow-up note...">{{ old('note') }}</textarea>
                @error('note')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Add note
                </button>
            </div>
        </form>
    </div>

    {{-- Notes history --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Note</th>
                    <th>Written by</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr id="row-{{ $note->id }}">
                        {{-- View mode --}}
                        <td id="text-{{ $note->id }}">{{ $note->note }}</td>
                        <td>{{ $note->author->name ?? '—' }}</td>
                        <td>{{ $note->created_at->format('Y-m-d H:i') }}</td>
                        <td class="td-actions">
                            {{-- Edit button --}}
                            <button class="btn-action btn-edit" title="Edit"
                                onclick="enableEdit({{ $note->id }})">
                                <i class="fas fa-pen"></i>
                            </button>

                            {{-- Edit form (hidden by default) --}}
                            <form id="form-edit-{{ $note->id }}" method="POST"
                                action="{{ route('prospects.notes.update', [$contact->id, $note->id]) }}"
                                style="display:none; margin-top:0.5rem;">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="from" value="{{ $from }}">
                                <textarea name="note" rows="2" class="form-input"
                                    id="input-{{ $note->id }}">{{ $note->note }}</textarea>
                                <div style="display:flex; gap:0.5rem; margin-top:0.4rem;">
                                    <button type="submit" class="btn-primary" style="padding:0.3rem 0.75rem; font-size:0.8rem;">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                    <button type="button" class="btn-secondary" style="padding:0.3rem 0.75rem; font-size:0.8rem;"
                                        onclick="cancelEdit({{ $note->id }})">
                                        Cancel
                                    </button>
                                </div>
                            </form>

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('prospects.notes.destroy', [$contact->id, $note->id]) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="{{ $from }}">
                                <button class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No notes registered.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        function enableEdit(id) {
            document.getElementById('text-' + id).style.display = 'none';
            document.getElementById('form-edit-' + id).style.display = 'block';
        }
        function cancelEdit(id) {
            document.getElementById('text-' + id).style.display = '';
            document.getElementById('form-edit-' + id).style.display = 'none';
        }
    </script>

@endsection