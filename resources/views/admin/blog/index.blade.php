@extends('layouts.admin')

@section('title', 'Blog')

@section('content')

    @php
        $esGestor = auth()
            ->user()
            ->hasAnyRole(['administrator']);
    @endphp

    {{-- Header --}}
    <div class="admin-page-header">
        <p class="admin-page-header__subtitle">Gestiona todos los artículos del blog.</p>
        <div class="admin-page-header__actions">
            @if ($esGestor)
                <a href="{{ route('blog.categorias.index') }}" class="btn btn--secondary">
                    <i data-lucide="tag" class="btn__icon"></i>
                    Categorías
                </a>
            @endif
            <a href="{{ route('blog.create') }}" class="btn btn--primary">
                <i data-lucide="plus" class="btn__icon"></i>
                Nuevo artículo
            </a>
        </div>
    </div>

    {{-- Filtros por estado --}}
    <div class="admin-filters">
        <a href="{{ route('blog.index') }}"
            class="admin-filters__link {{ !request('estado') ? 'admin-filters__link--active' : '' }}">
            Todas <span class="admin-filters__count">{{ $contadores['todas'] }}</span>
        </a>
        <span class="admin-filters__separator">|</span>
        <a href="{{ route('blog.index', ['estado' => 'publicada']) }}"
            class="admin-filters__link {{ request('estado') === 'publicada' ? 'admin-filters__link--active' : '' }}">
            Publicadas <span class="admin-filters__count">{{ $contadores['publicada'] }}</span>
        </a>
        <span class="admin-filters__separator">|</span>
        <a href="{{ route('blog.index', ['estado' => 'borrador']) }}"
            class="admin-filters__link {{ request('estado') === 'borrador' ? 'admin-filters__link--active' : '' }}">
            Borrador <span class="admin-filters__count">{{ $contadores['borrador'] }}</span>
        </a>
        <span class="admin-filters__separator">|</span>
        <a href="{{ route('blog.index', ['estado' => 'revision']) }}"
            class="admin-filters__link {{ request('estado') === 'revision' ? 'admin-filters__link--active' : '' }}">
            En revisión <span class="admin-filters__count">{{ $contadores['revision'] }}</span>
        </a>
    </div>

    {{-- Barra de búsqueda --}}
    <div class="admin-toolbar">
        <form method="GET" action="{{ route('blog.index') }}" class="admin-search">
            <i data-lucide="search" class="admin-search__icon"></i>
            <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar artículos..."
                class="admin-search__input">
            @if (request('estado'))
                <input type="hidden" name="estado" value="{{ request('estado') }}">
            @endif
        </form>
    </div>

    {{-- Tabla --}}
    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th class="admin-table__checkbox-col">
                        <input type="checkbox">
                    </th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Estado</th>
                    <th>Destacada</th>
                    <th>Autor</th>
                    <th>Vistas</th>
                    <th>Fecha</th>
                    <th class="admin-table__actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($posts as $post)
                    @php
                        $puedeEditar = $esGestor || ($post->autor_id === auth()->id() && $post->estado === 'borrador');
                    @endphp
                    <tr class="admin-table__row">
                        <td><input type="checkbox"></td>
                        <td>
                            @if ($puedeEditar)
                                <a href="{{ route('blog.edit', $post) }}" class="admin-table__title">
                                    {{ $post->titulo }}
                                </a>
                            @else
                                <span class="admin-table__title">{{ $post->titulo }}</span>
                            @endif
                        </td>
                        <td>{{ $post->categoria->nombre }}</td>
                        <td>
                            @if ($post->estado === 'publicada')
                                <span class="status-badge status-badge--abierto">Publicada</span>
                            @elseif ($post->estado === 'revision')
                                <span class="status-badge status-badge--curso">En revisión</span>
                            @else
                                <span class="status-badge status-badge--proximo">Borrador</span>
                            @endif
                        </td>
                        <td>
                            @if ($post->destacada_estado === 'destacada')
                                <span class="tag-badge tag-badge--destacada">Destacada #{{ $post->destacada_orden }}</span>
                            @else
                                <span class="tag-badge tag-badge--ninguna">—</span>
                            @endif
                        </td>
                        <td>{{ $post->autor->name }}</td>
                        <td>{{ number_format($post->vistas) }}</td>
                        <td>{{ $post->published_at?->format('d M, Y') ?? '—' }}</td>
                        <td>
                            <div class="admin-table__actions">
                                @if ($puedeEditar)
                                    <a href="{{ route('blog.edit', $post) }}" class="admin-table__action" title="Editar">
                                        <i data-lucide="pencil"></i>
                                    </a>
                                @endif
                                <a href="{{ route('blog.post', $post->slug) }}" class="admin-table__action" title="Ver"
                                    target="_blank">
                                    <i data-lucide="eye"></i>
                                </a>
                                @if ($esGestor)
                                    <form action="{{ route('blog.destroy', $post) }}" method="POST"
                                        class="admin-table__delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            class="admin-table__action admin-table__action--danger js-eliminar-post"
                                            title="Eliminar">
                                            <i data-lucide="trash-2"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--gris-texto);">
                            No hay artículos todavía.
                            <a href="{{ route('blog.create') }}"
                                style="color: var(--color-primary); font-weight: 600;">Crea el primero</a>.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if ($posts->hasPages())
        <div class="admin-pagination">
            <span class="admin-pagination__info">
                Mostrando {{ $posts->firstItem() }}–{{ $posts->lastItem() }} de {{ $posts->total() }} artículos
            </span>
            <div class="admin-pagination__links">
                @if ($posts->onFirstPage())
                    <span class="admin-pagination__link admin-pagination__link--disabled">
                        <i data-lucide="chevron-left"></i>
                    </span>
                @else
                    <a href="{{ $posts->previousPageUrl() }}" class="admin-pagination__link">
                        <i data-lucide="chevron-left"></i>
                    </a>
                @endif

                @foreach ($posts->getUrlRange(1, $posts->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                        class="admin-pagination__link {{ $page === $posts->currentPage() ? 'admin-pagination__link--active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if ($posts->hasMorePages())
                    <a href="{{ $posts->nextPageUrl() }}" class="admin-pagination__link">
                        <i data-lucide="chevron-right"></i>
                    </a>
                @else
                    <span class="admin-pagination__link admin-pagination__link--disabled">
                        <i data-lucide="chevron-right"></i>
                    </span>
                @endif
            </div>
        </div>
    @endif

@endsection
