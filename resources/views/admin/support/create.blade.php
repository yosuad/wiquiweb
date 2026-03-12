@extends('layouts.admin')

@section('title', 'New ticket')

@php $pageTitle = 'Support'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">New support ticket</p>
            <a href="{{ route('support') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to support
            </a>
        </div>
    </div>

    <div class="form-container form-container--spaced">
        <form method="POST" action="{{ route('support.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label for="contact_id">Client <span class="required">*</span></label>
                    <select id="contact_id" name="contact_id" class="form-input">
                        <option value="">— Select client —</option>
                        @foreach($contacts as $contact)
                            <option value="{{ $contact->id }}" {{ old('contact_id') == $contact->id ? 'selected' : '' }}>
                                {{ $contact->company_name ?? $contact->first_name . ' ' . $contact->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('contact_id') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="assigned_to">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="">— Select agent —</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ old('assigned_to') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_to') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="subject">Matter <span class="required">*</span></label>
                    <input type="text" id="subject" name="subject"
                           value="{{ old('subject') }}"
                           class="form-input @error('subject') is-invalid @enderror"
                           placeholder="Brief description of the issue...">
                    @error('subject') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="priority">Priority <span class="required">*</span></label>
                    <select id="priority" name="priority" class="form-input">
                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high"   {{ old('priority') == 'high'   ? 'selected' : '' }}>High</option>
                        <option value="low"    {{ old('priority') == 'low'    ? 'selected' : '' }}>Low</option>
                    </select>
                    @error('priority') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group" style="flex: 1;">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"
                              class="form-input @error('description') is-invalid @enderror"
                              rows="5"
                              placeholder="Detailed description of the issue or request...">{{ old('description') }}</textarea>
                    @error('description') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-ticket-alt"></i> Create ticket
                </button>
            </div>

        </form>
    </div>

@endsection