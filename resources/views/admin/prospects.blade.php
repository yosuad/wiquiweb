@extends('layouts.admin')

@section('title', 'Prospectos')

@php $pageTitle = 'Prospectos'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Leads y seguimiento de conversión</p>
            <a href="{{ route('prospects.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Agregar lead
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>WhatsApp</th>
                    <th>Correo</th>
                    <th>Origen</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Asignado</th>
                    <th class="text-center">Notas</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects as $prospect)
                    @php
                        $prospectStatus = $prospect->prospectDetail->status ?? 'nuevo';
                        $badgeClass = match ($prospectStatus) {
                            'nuevo'       => 'badge-new',
                            'contactado'  => 'badge-contact',
                            'seguimiento' => 'badge-follow',
                            'cerrado'     => 'badge-closed',
                            'perdido'     => 'badge-lost',
                            default       => 'badge-new',
                        };
                    @endphp
                    <tr>
                        <td class="font-medium">{{ $prospect->company ?? '—' }}</td>
                        <td>{{ $prospect->name }}</td>
                        <td>{{ $prospect->whatsapp ?? '—' }}</td>
                        <td class="td-email">{{ $prospect->email ?? '—' }}</td>
                        <td>{{ ucfirst($prospect->prospectDetail->origin ?? '—') }}</td>
                        <td>{{ $prospect->prospectDetail->service->name ?? '—' }}</td>
                        <td>
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($prospectStatus) }}
                            </span>
                        </td>
                        <td>{{ $prospect->created_at->format('Y-m-d') }}</td>
                        <td>{{ $prospect->prospectDetail->agent->name ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('prospects.notes.index', $prospect->id) }}" class="btn-action btn-notes"
                                title="Ver notas">
                                <i class="fas fa-clipboard-list"></i>
                            </a>
                        </td>
                        <td class="td-actions">
                            @if($prospectStatus === 'cerrado')
                                <a href="{{ route('prospects.close', $prospect->id) }}" class="btn-action btn-notes" title="Generar factura">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                            @endif
                            <a href="{{ route('prospects.edit', $prospect->id) }}" class="btn-action btn-edit"
                                title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('prospects.destroy', $prospect->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="text-center">No hay prospectos registrados.</td>
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