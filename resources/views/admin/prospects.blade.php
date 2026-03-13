@extends('layouts.admin')

@section('title', 'Prospects')

@php $pageTitle = 'Prospects'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Leads and conversion tracking</p>
            <a href="{{ route('prospects.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Add lead
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>WhatsApp</th>
                    <th>Origin</th>
                    <th>Type / Interest</th>
                    <th>Status</th>
                    <th>Assigned to</th>
                    <th>Date</th>
                    <th class="text-center">Msg</th>
                    <th class="text-center">Notes</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects as $prospect)
                    @php
                        [$badgeClass, $badgeText] = match ($prospect->pipeline_stage) {
                            'closing'         => ['badge-follow',  'Closing'],
                            'pending_payment' => ['badge-contact', 'Pending payment'],
                            default           => match ($prospect->status) {
                                'prospect' => ['badge-new',    'Prospect'],
                                'customer' => ['badge-closed', 'Customer'],
                                'lost'     => ['badge-lost',   'Lost'],
                                default    => ['badge-new',    'Prospect'],
                            },
                        };
                    @endphp
                    <tr>
                        <td class="font-medium">{{ $prospect->first_name }} {{ $prospect->last_name }}</td>
                        <td>{{ $prospect->whatsapp ?? '—' }}</td>
                        <td>{{ ucfirst($prospect->origin ?? '—') }}</td>
                        <td>
                            @if($prospect->client_type)
                                <span class="badge badge-contact" style="font-size:0.65rem;">{{ ucfirst($prospect->client_type) }}</span>
                            @endif
                            @if($prospect->service_interest)
                                <span class="badge badge-new" style="font-size:0.65rem;">{{ $prospect->service_interest }}</span>
                            @endif
                            @if(!$prospect->client_type && !$prospect->service_interest)
                                —
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $badgeClass }}">
                                {{ $badgeText }}
                            </span>
                        </td>
                        <td>{{ $prospect->agent->name ?? '—' }}</td>
                        <td>{{ $prospect->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">
                            @if($prospect->message_sent === 'n8n')
                                {{-- n8n lo envió — solo visual, no se toca --}}
                                <i class="fas fa-check" style="color: var(--paid);" title="Enviado por n8n"></i>
                            @else
                                {{-- manual o no — botón toggle --}}
                                <form method="POST" action="{{ route('contacts.message.toggle', $prospect->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action"
                                        title="{{ $prospect->message_sent === 'manual' ? 'Quitar marca' : 'Marcar como enviado' }}"
                                        style="background: none; border: none; cursor: pointer;
                                               color: {{ $prospect->message_sent === 'manual' ? '#189dbb' : 'var(--text-secondary)' }};">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('prospects.notes.index', $prospect->id) }}" class="btn-action btn-notes" title="View notes">
                                <i class="fas fa-clipboard-list"></i>
                            </a>
                        </td>
                        <td class="td-actions">
                            <a href="{{ route('prospects.edit', $prospect->id) }}" class="btn-action btn-edit" title="Edit">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('prospects.destroy', $prospect->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No prospects registered.</td>
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