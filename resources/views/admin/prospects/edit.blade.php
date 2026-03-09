@extends('layouts.admin')

@section('title', 'Edit Lead')

@php $pageTitle = 'Edit Lead'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Edit prospect</p>
            <a href="{{ route($redirectTo) }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('prospects.update', $contact->id) }}">
            @csrf
            @method('PUT')

            <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

            {{-- Row 1: First name and Last name --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="first_name">First name <span class="required">*</span></label>
                    <input type="text" id="first_name" name="first_name"
                           value="{{ old('first_name', $contact->first_name) }}"
                           class="form-input @error('first_name') is-invalid @enderror"
                           placeholder="First name">
                    @error('first_name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="last_name">Last name</label>
                    <input type="text" id="last_name" name="last_name"
                           value="{{ old('last_name', $contact->last_name) }}"
                           class="form-input"
                           placeholder="Last name">
                </div>
            </div>

            {{-- Row 2: WhatsApp and Phone --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="whatsapp">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp"
                           value="{{ old('whatsapp', $contact->whatsapp) }}"
                           class="form-input"
                           placeholder="+57 320 413 25 00">
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $contact->phone) }}"
                           class="form-input"
                           placeholder="+57 300 758 35 00">
                </div>
            </div>

            {{-- Row 3: Email and Company --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $contact->email) }}"
                           class="form-input @error('email') is-invalid @enderror"
                           placeholder="email@example.com">
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="company_name">Company</label>
                    <input type="text" id="company_name" name="company_name"
                           value="{{ old('company_name', $contact->company_name) }}"
                           class="form-input"
                           placeholder="Company name (optional)">
                </div>
            </div>

            {{-- Row 4: Assigned and Origin --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="assigned_to">Assigned to</label>
                    <select id="assigned_to" name="assigned_to" class="form-input">
                        <option value="">— Select —</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}"
                                {{ (int) old('assigned_to', $contact->assigned_to) === $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="origin">Origin</label>
                    <select id="origin" name="origin" class="form-input">
                        <option value="">— Select —</option>
                        @foreach(['facebook', 'instagram', 'referral', 'web'] as $origin)
                            <option value="{{ $origin }}"
                                {{ old('origin', $contact->origin) == $origin ? 'selected' : '' }}>
                                {{ ucfirst($origin) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Row 5: Service interest and Status --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="service_interest">Service interest</label>
                    <input type="text" id="service_interest" name="service_interest"
                           value="{{ old('service_interest', $contact->service_interest) }}"
                           class="form-input"
                           placeholder="e.g. Hosting, SSL, Web design">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        @foreach(['prospect', 'customer', 'lost'] as $status)
                            <option value="{{ $status }}"
                                {{ old('status', $contact->status) == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update lead
                </button>
            </div>

        </form>
    </div>

@endsection