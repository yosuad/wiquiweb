@extends('layouts.admin')

@section('title', 'Servicios')

@php $pageTitle = 'Servicios'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Gestión de servicios y precios</p>
            <a href="{{ route('services.create') }}" class="btn-primary">
                <i class="fas fa-plus"></i> Agregar servicio
            </a>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Descripción</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td class="font-medium">{{ $service->name }}</td>
                        <td class="td-email">{{ $service->slug }}</td>
                        <td>{{ $service->description ?? '—' }}</td>
                        <td class="td-actions">
                            <a href="{{ route('services.prices', $service->id) }}" class="btn-action btn-notes" title="Ver precios">
                                <i class="fas fa-tags"></i>
                            </a>
                            <a href="{{ route('services.edit', $service->id) }}" class="btn-action btn-edit" title="Editar">
                                <i class="fas fa-pen"></i>
                            </a>
                            <form method="POST" action="{{ route('services.destroy', $service->id) }}">
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
                        <td colspan="4" class="text-center">No hay servicios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection