@extends('layouts.admin')

@section('title', 'Edit Customer')

@php $pageTitle = 'Edit Customer'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Edit customer</p>
            <a href="{{ route('customers') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to customers
            </a>
        </div>
    </div>

    {{-- Read-only info --}}
    <div class="form-container" style="margin-bottom: 1rem;">
        <div class="form-row">
            <div class="form-group">
                <label>Origin</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ ucfirst($contact->origin ?? '—') }}
                </div>
            </div>
            <div class="form-group">
                <label>Client type</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ ucfirst($contact->client_type ?? '—') }}
                </div>
            </div>
            <div class="form-group">
                <label>Service interest</label>
                <div class="form-input" style="background: var(--bg-body); cursor:default;">
                    {{ $contact->service_interest ?? '—' }}
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('customers.update', $contact->id) }}">
            @csrf
            @method('PUT')

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

            {{-- Row 4: Document type and Document number --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="document_type">Document type</label>
                    <select id="document_type" name="document_type" class="form-input">
                        <option value="" disabled selected>— Select —</option>
                        <option value="national_id"  {{ old('document_type', $contact->document_type) == 'national_id'  ? 'selected' : '' }}>CC — Cédula de ciudadanía</option>
                        <option value="tax_id"       {{ old('document_type', $contact->document_type) == 'tax_id'       ? 'selected' : '' }}>NIT — Número de identificación tributaria</option>
                        <option value="rut"          {{ old('document_type', $contact->document_type) == 'rut'          ? 'selected' : '' }}>RUT — Registro único tributario</option>
                        <option value="foreign_id"   {{ old('document_type', $contact->document_type) == 'foreign_id'   ? 'selected' : '' }}>CE — Cédula de extranjería</option>
                        <option value="passport"     {{ old('document_type', $contact->document_type) == 'passport'     ? 'selected' : '' }}>Passport</option>
                        <option value="ein"          {{ old('document_type', $contact->document_type) == 'ein'          ? 'selected' : '' }}>EIN — Employer Identification Number (USA)</option>
                    </select>
                    @error('document_type') <span class="form-error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="document_number">Document number</label>
                    <input type="text" id="document_number" name="document_number"
                           value="{{ old('document_number', $contact->document_number) }}"
                           class="form-input @error('document_number') is-invalid @enderror"
                           placeholder="Ej: 1234567890">
                    @error('document_number') <span class="form-error">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Row 5: Address --}}
            <div class="form-row">
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address"
                           value="{{ old('address', $contact->address) }}"
                           class="form-input @error('address') is-invalid @enderror"
                           placeholder="Ej: Calle 123 #45-67, Medellín">
                    @error('address') <span class="form-error">{{ $message }}</span> @enderror
                </div>
                <div class="form-group"></div>
            </div>

            {{-- Row 6: Assigned to and Status --}}
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
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-input">
                        <option value="customer" {{ old('status', $contact->status) == 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="lost"     {{ old('status', $contact->status) == 'lost'     ? 'selected' : '' }}>Lost</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Update customer
                </button>
            </div>

        </form>
    </div>

    {{-- Contact history log --}}
    <div class="form-container" style="margin-top: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 700; color: var(--text-primary); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border);">
            <i class="fas fa-clock-rotate-left" style="color: var(--primary-color);"></i> Contact History
        </h3>

        <div class="dash-activity">
            @forelse($logs as $log)
                <div class="dash-activity__item">
                    @if($log->type === 'status_change')
                        <div class="dash-activity__dot dash-activity__dot--amber"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $log->author->name ?? '—' }}</strong>
                            @if($log->from === null)
                                registered contact as
                                <span class="badge badge-new" style="font-size:0.7rem;">{{ ucfirst($log->to) }}</span>
                            @else
                                changed status from
                                <span class="badge {{ $log->from === 'prospect' ? 'badge-new' : ($log->from === 'customer' ? 'badge-closed' : 'badge-lost') }}" style="font-size:0.7rem;">{{ ucfirst($log->from) }}</span>
                                to
                                <span class="badge {{ $log->to === 'prospect' ? 'badge-new' : ($log->to === 'customer' ? 'badge-closed' : 'badge-lost') }}" style="font-size:0.7rem;">{{ ucfirst($log->to) }}</span>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @elseif($log->type === 'assignment_change')
                        <div class="dash-activity__dot dash-activity__dot--blue"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $log->author->name ?? '—' }}</strong>
                            @if($log->from === null)
                                assigned to <em>{{ $log->to }}</em>
                            @else
                                reassigned from <em>{{ $log->from }}</em> to <em>{{ $log->to }}</em>
                            @endif
                            <span class="dash-activity__time">{{ $log->created_at->diffForHumans() }}</span>
                        </div>
                    @endif
                </div>
            @empty
                <p class="dash-empty">No history recorded yet.</p>
            @endforelse
        </div>
    </div>

@endsection