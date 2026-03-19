<div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar__header">
            <a href="{{ route('dashboard') }}" class="sidebar__logo">
                <x-application-logo class="sidebar__logo-img" />
            </a>
        </div>

        <nav class="sidebar__nav">
            <a href="{{ route('dashboard') }}"
                class="sidebar__link {{ request()->routeIs('dashboard') ? 'sidebar__link--active' : '' }}">
                Dashboard
            </a>

            @php
                $editingLost     = request()->routeIs('prospects.edit') && (isset($redirectTo) && $redirectTo === 'prospects.lost');
                $editingCustomer = (request()->routeIs('prospects.edit') && isset($redirectTo) && $redirectTo === 'customers')
                                || request()->routeIs('customers.edit')
                                || request()->routeIs('customers.show');
            @endphp

            @can('view prospects')
                <a href="{{ route('prospects.lost') }}"
                    class="sidebar__link {{ request()->routeIs('prospects.lost') || $editingLost || (request()->routeIs('prospects.notes.*') && request()->get('from') === 'lost') ? 'sidebar__link--active' : '' }}">
                    Prospectos perdidos
                </a>

                <a href="{{ route('prospects.index') }}"
                    class="sidebar__link {{ request()->routeIs('prospects.index') || request()->routeIs('prospects.create') || request()->routeIs('prospects.close') || (request()->routeIs('prospects.edit') && !$editingLost && !$editingCustomer) || (request()->routeIs('prospects.notes.*') && request()->get('from') !== 'lost') ? 'sidebar__link--active' : '' }}">
                    Prospectos
                </a>
            @endcan

            @can('view customers')
                <a href="{{ route('customers') }}"
                    class="sidebar__link {{ request()->routeIs('customers') || $editingCustomer ? 'sidebar__link--active' : '' }}">
                    Clientes
                </a>
            @endcan

            @can('view billing')
                <a href="{{ route('billing') }}"
                    class="sidebar__link {{ request()->routeIs('billing') || request()->routeIs('billing.*') ? 'sidebar__link--active' : '' }}">
                    Facturación
                </a>
            @endcan

            @can('view support')
                <a href="{{ route('support') }}"
                    class="sidebar__link {{ request()->routeIs('support') || request()->routeIs('support.*') ? 'sidebar__link--active' : '' }}">
                    Soporte
                </a>
            @endcan

            @role('administrator')
                <a href="{{ route('services.index') }}"
                    class="sidebar__link {{ request()->routeIs('services.*') ? 'sidebar__link--active' : '' }}">
                    Servicios
                </a>

                <a href="{{ route('admin') }}"
                    class="sidebar__link {{ request()->routeIs('admin') ? 'sidebar__link--active' : '' }}">
                    Administración
                </a>
            @endrole
        </nav>
    </aside>