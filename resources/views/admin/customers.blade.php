@extends('layouts.admin')

@section('title', 'Clientes')

@php $pageTitle = 'Clientes'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Clientes activos</p>
        </div>
    </div>

    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Empresa</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Servicio</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr>
                        <td class="font-medium">{{ $customer->company ?? '—' }}</td>
                        <td>{{ $customer->name }} {{ $customer->last_name }}</td>
                        <td>{{ $customer->phone ?? '—' }}</td>
                        <td class="td-email">{{ $customer->email ?? '—' }}</td>
                        <td>{{ $customer->prospectDetail->service->name ?? '—' }}</td>
                        <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No hay clientes registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($customers->hasPages())
        <div class="pagination-wrapper">
            {{ $customers->links() }}
        </div>
    @endif

@endsection