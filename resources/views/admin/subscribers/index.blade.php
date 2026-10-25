@extends('layouts.admin')

@section('title', 'Suscriptores')

@php $pageTitle = 'Suscriptores'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Lista de suscriptores del newsletter</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="dashboard-home" style="grid-template-columns: repeat(3, 1fr); margin-bottom: 1.5rem;">
        <div class="dash-card">
            <div class="dash-card__icon dash-card__icon--prospects">
                <i data-lucide="mail"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $total }}</span>
                <span class="dash-card__label">Total</span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card__icon dash-card__icon--customers">
                <i data-lucide="check-circle"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $active }}</span>
                <span class="dash-card__label">Activos</span>
            </div>
        </div>
        <div class="dash-card">
            <div class="dash-card__icon dash-card__icon--support">
                <i data-lucide="user-x"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $unsubscribed }}</span>
                <span class="dash-card__label">Dados de baja</span>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="form-container form-container--spaced">
        <form method="GET" action="{{ route('subscribers.index') }}">
            <div class="form-row">
                <div class="form-group">
                    <label for="search">Buscar email</label>
                    <input type="text" id="search" name="search"
                           value="{{ $search ?? '' }}"
                           class="form-input"
                           placeholder="email@ejemplo.com">
                </div>
                <div class="form-group">
                    <label for="status">Estado</label>
                    <select id="status" name="status" class="form-input">
                        <option value="">— Todos —</option>
                        <option value="active"       {{ ($status ?? '') == 'active'       ? 'selected' : '' }}>Activos</option>
                        <option value="unsubscribed" {{ ($status ?? '') == 'unsubscribed' ? 'selected' : '' }}>Dados de baja</option>
                    </select>
                </div>
                <div class="subscribers__actions">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="search"></i> Filtrar
                    </button>
                    @if($search || $status)
                        <a href="{{ route('subscribers.index') }}" class="btn-secondary">
                            <i data-lucide="x"></i> Limpiar
                        </a>
                    @endif
                    <a href="{{ route('subscribers.export', ['status' => $status]) }}" class="btn-secondary">
                        <i data-lucide="download"></i> Exportar CSV
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Origin</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($subscribers as $subscriber)
                    <tr>
                        <td class="td-email">{{ $subscriber->email }}</td>
                        <td>{{ $subscriber->origin }}</td>
                        <td>
                            <span class="badge {{ $subscriber->status === 'active' ? 'badge-closed' : 'badge-lost' }}">
                                {{ $subscriber->status === 'active' ? 'Activo' : 'Dado de baja' }}
                            </span>
                        </td>
                        <td>{{ $subscriber->created_at->format('Y-m-d') }}</td>
                        <td class="td-actions">
                            <form method="POST" action="{{ route('subscribers.destroy', $subscriber->id) }}"
                                data-confirm="¿Eliminar a {{ $subscriber->email }}? Esta acción no se puede deshacer.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                    <i data-lucide="trash-2"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No hay suscriptores registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($subscribers->hasPages())
            <div class="pagination-wrapper">
                {{ $subscribers->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

@endsection