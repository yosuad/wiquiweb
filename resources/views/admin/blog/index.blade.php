@extends('layouts.admin')

@section('title', 'Blog')

@php $pageTitle = 'Blog'; @endphp

@section('content')

    {{-- Header --}}
    <div class="admin-page-header">
        <p class="admin-page-header__subtitle">Gestiona todos los artículos del blog.</p>
        <div class="admin-page-header__actions">
            <a href="{{ route('blog.categories.index') }}" class="btn-secondary">
                <i data-lucide="tag"></i> Categorías
            </a>
            <a href="{{ route('blog.create') }}" class="btn-primary">
                <i data-lucide="plus"></i> Nuevo artículo
            </a>
        </div>
    </div>

    {{-- Filtros por estado --}}
    <div class="admin-filters">
        <a href="{{ route('blog.index') }}"
            class="admin-filters__link {{ !request('status') ? 'admin-filters__link--active' : '' }}">
            Todas <span class="admin-filters__count">{{ $counts['all'] }}</span>
        </a>
        <span class="admin-filters__separator">|</span>
        <a href="{{ route('blog.index', ['status' => 'published']) }}"
            class="admin-filters__link {{ request('status') === 'published' ? 'admin-filters__link--active' : '' }}">
            Publicadas <span class="admin-filters__count">{{ $counts['published'] }}</span>
        </a>
        <span class="admin-filters__separator">|</span>
        <a href="{{ route('blog.index', ['status' => 'draft']) }}"
            class="admin-filters__link {{ request('status') === 'draft' ? 'admin-filters__link--active' : '' }}">
            Borrador <span class="admin-filters__count">{{ $counts['draft'] }}</span>
        </a>
    </div>

    {{-- Buscador --}}
    <div class="admin-toolbar">
        <form method="GET" action="{{ route('blog.index') }}" class="admin-search">
            <i data-lucide="search" class="admin-search__icon"></i>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar artículos..."
                class="admin-search__input">
            @if (request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
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
                    <th>Principal</th>
                    <th>Autor</th>
                    <th>Vistas</th>
                    <th>Fecha</th>
                    <th class="admin-table__actions-col">Acciones</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($posts as $post)
                    <tr class="admin-table__row">
                        <td><input type="checkbox"></td>
                        <td>
                            <a href="{{ route('blog.edit', $post) }}" class="admin-table__title">
                                {{ $post->title }}
                            </a>
                        </td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            @if ($post->status === 'published')
                                <span class="status-badge status-badge--published">Publicada</span>
                            @else
                                <span class="status-badge status-badge--draft">Borrador</span>
                            @endif
                        </td>
                        <td>
                            @if ($post->is_featured)
                                <span class="tag-badge tag-badge--featured">Principal</span>
                            @else
                                <span class="tag-badge tag-badge--none">—</span>
                            @endif
                        </td>
                        <td>{{ $post->author->name }}</td>
                        <td>{{ number_format($post->views) }}</td>
                        <td>{{ $post->published_at?->locale('es')->translatedFormat('d M, Y') ?? '—' }}</td>
                        <td>
                            <div class="admin-table__actions">
                                <a href="{{ route('blog.edit', $post) }}" class="admin-table__action" title="Editar">
                                    <i data-lucide="pencil"></i>
                                </a>
                                @if ($post->status === 'published')
                                    <a href="{{ route('blog.post', $post->slug) }}" class="admin-table__action"
                                        title="Ver en la web" target="_blank">
                                        <i data-lucide="eye"></i>
                                    </a>
                                @endif
                                <form method="POST" action="{{ route('blog.destroy', $post) }}"
                                    data-confirm="¿Eliminar el artículo «{{ $post->title }}»? Esta acción no se puede deshacer.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-table__action admin-table__action--danger"
                                        title="Eliminar">
                                        <i data-lucide="trash-2"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="admin-table__empty">
                            No hay artículos todavía.
                            <a href="{{ route('blog.create') }}" class="admin-table__empty-link">Crea el primero</a>.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    {{ $posts->links() }}

@endsection
