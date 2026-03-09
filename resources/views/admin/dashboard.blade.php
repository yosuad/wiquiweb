@extends('layouts.admin')

@section('title', 'Dashboard')

@php $pageTitle = 'Dashboard'; @endphp

@section('content')

    <div class="dashboard-home">

        {{-- Prospects: col 1, row 1 --}}
        <div class="dash-card dash-card--prospectos">
            <div class="dash-card__icon dash-card__icon--prospects">
                <i class="fas fa-user-plus fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $totalProspects }}</span>
                <span class="dash-card__label">Prospects</span>
            </div>
            <span class="dash-card__badge dash-card__badge--neutral">This month</span>
        </div>

        {{-- New customers: col 2, row 1 --}}
        <div class="dash-card dash-card--clientes">
            <div class="dash-card__icon dash-card__icon--customers">
                <i class="fas fa-users fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $newCustomersThisMonth }}</span>
                <span class="dash-card__label">New customers</span>
            </div>
            <span class="dash-card__badge {{ $customersPercent >= 100 ? 'dash-card__badge--up' : 'dash-card__badge--warning' }}">
                {{ $customersPercent }}% of goal
            </span>
        </div>

        {{-- Billing: col 3, row 1 --}}
        <div class="dash-card dash-card--facturacion">
            <div class="dash-card__icon dash-card__icon--billing">
                <i class="fas fa-credit-card fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">$ {{ number_format($monthlyRevenue, 2) }}</span>
                <span class="dash-card__label">Monthly revenue</span>
            </div>
            <span class="dash-card__badge {{ $revenuePercent >= 100 ? 'dash-card__badge--up' : 'dash-card__badge--warning' }}">
                {{ $revenuePercent }}% of goal
            </span>
        </div>

        {{-- Services: col 4, row 1 --}}
        <div class="dash-card dash-card--servicios">
            <div class="dash-card__icon dash-card__icon--services">
                <i class="fas fa-briefcase fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $totalServices }}</span>
                <span class="dash-card__label">Services</span>
            </div>
            <span class="dash-card__badge dash-card__badge--neutral">Catalog</span>
        </div>

        {{-- Team: col 1, row 2 --}}
        <div class="dash-card dash-card--equipo">
            <div class="dash-card__icon dash-card__icon--admin">
                <i class="fas fa-shield-halved fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $totalStaff }}</span>
                <span class="dash-card__label">Team</span>
            </div>
            <span class="dash-card__badge dash-card__badge--neutral">Agents</span>
        </div>

        {{-- Support: col 2, row 2 --}}
        <div class="dash-card dash-card--soporte">
            <div class="dash-card__icon dash-card__icon--support">
                <i class="fas fa-headset fa-lg"></i>
            </div>
            <div class="dash-card__info">
                <span class="dash-card__number">{{ $totalSupports }}</span>
                <span class="dash-card__label">Support</span>
            </div>
            <span class="dash-card__badge dash-card__badge--neutral">Open tickets</span>
        </div>

        {{-- Recent activity: col 3, row 2 --}}
        <div class="dash-section dash-section--actividad">
            <h3 class="dash-section__title">Recent Activity</h3>
            <div class="dash-activity">
                @forelse($recentProspects as $prospect)
                    <div class="dash-activity__item">
                        <div class="dash-activity__dot dash-activity__dot--green"></div>
                        <div class="dash-activity__text">
                            <strong>{{ $prospect->first_name }} {{ $prospect->last_name }}</strong> registered as a prospect
                            <span class="dash-activity__time">{{ $prospect->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @empty
                    <p class="dash-empty">No recent activity.</p>
                @endforelse
            </div>
        </div>

        {{-- Pending payments: col 4, row 2 --}}
        <div class="dash-section dash-section--pagos">
            <h3 class="dash-section__title">Pending Payments</h3>
            <div class="dash-pending">
                @forelse($pendingInvoices as $invoice)
                    <div class="dash-pending__item">
                        <span class="dash-pending__name">
                            {{ $invoice->contactService->contact->company_name ?? $invoice->contactService->contact->first_name . ' ' . $invoice->contactService->contact->last_name }}
                        </span>
                        <span class="dash-pending__amount dash-pending__amount--warning">
                            $ {{ number_format($invoice->amount, 2) }}
                        </span>
                    </div>
                @empty
                    <p class="dash-empty">No pending payments.</p>
                @endforelse

                @if($pendingInvoices->isNotEmpty())
                    <div class="dash-pending__total">
                        <span>Total pending</span>
                        <strong>$ {{ number_format($totalPending, 2) }}</strong>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sales goal: col 1-4, row 3 --}}
        <div class="dash-section dash-section--meta">
            <h3 class="dash-section__title">Sales Goal — {{ now()->format('F Y') }}</h3>

            <div class="dash-progress">
                <div class="dash-progress__labels">
                    <span>Revenue $ {{ number_format($monthlyRevenue, 2) }} / $ {{ number_format($metaVentas, 2) }}</span>
                    <span>{{ $revenuePercent }}%</span>
                </div>
                <div class="dash-progress__bar">
                    <div class="dash-progress__fill {{ $revenuePercent >= 100 ? 'dash-progress__fill--success' : '' }}"
                         style="width: {{ $revenuePercent }}%"></div>
                </div>
            </div>

            <div class="dash-progress">
                <div class="dash-progress__labels">
                    <span>Customers {{ $newCustomersThisMonth }} / {{ $metaClientes }}</span>
                    <span>{{ $customersPercent }}%</span>
                </div>
                <div class="dash-progress__bar">
                    <div class="dash-progress__fill {{ $customersPercent >= 100 ? 'dash-progress__fill--success' : '' }}"
                         style="width: {{ $customersPercent }}%"></div>
                </div>
            </div>
        </div>

    </div>

@endsection