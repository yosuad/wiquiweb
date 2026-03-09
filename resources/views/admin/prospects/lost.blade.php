@extends('layouts.admin')

@section('title', 'Prospectos Perdidos')

@php $pageTitle = 'Prospectos Perdidos'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Leads que no se convirtieron</p>
            <a href="{{ route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Ver activos
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
                    <th>Fecha</th>
                    <th>Asignado</th>
                    <th class="text-center">Notas</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospects as $prospect)
                    <tr>
                        <td class="font-medium">{{ $prospect->company ?? '—' }}</td>
                        <td>{{ $prospect->name }}</td>
                        <td>{{ $prospect->whatsapp ?? '—' }}</td>
                        <td class="td-email">{{ $prospect->email ?? '—' }}</td>
                        <td>{{ ucfirst($prospect->prospectDetail->origin ?? '—') }}</td>
                        <td>{{ $prospect->prospectDetail->service->name ?? '—' }}</td>
                        <td>{{ $prospect->created_at->format('Y-m-d') }}</td>
                        <td>{{ $prospect->prospectDetail->agent->name ?? '—' }}</td>
                        <td class="text-center">
                            <a href="{{ route('prospects.notes.index', $prospect->id) }}?from=lost"
                                class="btn-action btn-notes" title="Ver notas">
                                <i class="fas fa-clipboard-list"></i>
                            </a>
                        </td>
                        <td class="td-actions">
                            <a href="{{ route('prospects.edit', $prospect->id) }}" class="btn-action btn-edit"
                                title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('prospects.destroy', $prospect->id) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="redirect_to" value="prospects.lost">
                                <button class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center">No hay prospectos perdidos.</td>
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
