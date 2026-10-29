{{--
    Categorías del blog (panel admin)
    - Columna izquierda: formulario para crear una categoría.
    - Columna derecha: listado con acciones (predeterminada, editar, eliminar).
    Los mensajes de éxito/error los muestra alerts.js (session success / error).
--}}

@extends('layouts.admin')

@section('title', 'Categorías del blog')

@php $pageTitle = 'Categorías del blog'; @endphp

@section('content')

    {{-- ── Encabezado ── --}}
    <div class="admin-page-header">
        <div>
            <a href="{{ route('blog.index') }}" class="post-form__back">
                <i data-lucide="arrow-left"></i> Volver al blog
            </a>
            <p class="admin-page-header__subtitle">Gestiona las categorías de los artículos del blog.</p>
        </div>
    </div>

    <div class="blog-categories">

        {{-- ── Formulario para agregar ── --}}
        <div class="form-box">
            <h3 class="form-box__title">Agregar categoría</h3>

            <form method="POST" action="{{ route('blog.categories.store') }}">
                @csrf

                {{-- Nombre --}}
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Ej: Marketing digital" class="form-input">
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Slug (opcional: si se deja vacío se genera del nombre) --}}
                <div class="form-group">
                    <label for="slug">Slug (opcional)</label>
                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}"
                        placeholder="ej: marketing-digital" class="form-input">
                    @error('slug')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions form-actions--stacked">
                    <button type="submit" class="btn-primary">
                        <i data-lucide="plus"></i> Crear categoría
                    </button>
                </div>
            </form>
        </div>

        {{-- ── Listado ── --}}
        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Artículos</th>
                        <th>Predeterminada</th>
                        <th class="admin-table__actions-col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="admin-table__row">
                            <td class="admin-table__title">{{ $category->name }}</td>
                            <td>{{ $category->posts_count }}</td>

                            {{-- Predeterminada: etiqueta o botón para marcarla --}}
                            <td>
                                @if ($category->is_default)
                                    <span class="tag-badge tag-badge--default">Predeterminada</span>
                                @else
                                    <form action="{{ route('blog.categories.default', $category) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="admin-table__link-button">
                                            <i data-lucide="star" class="admin-table__link-button-icon"></i>
                                            Marcar como predeterminada
                                        </button>
                                    </form>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td>
                                <div class="admin-table__actions">
                                    {{-- Editar: abre una ventana para cambiar el nombre (blog-categories.js) --}}
                                    <button type="button" class="admin-table__action js-category-edit" title="Editar"
                                        data-name="{{ $category->name }}"
                                        data-url="{{ route('blog.categories.update', $category) }}">
                                        <i data-lucide="pencil"></i>
                                    </button>

                                    {{-- Eliminar: la predeterminada no se puede eliminar --}}
                                    @if (!$category->is_default)
                                        <form action="{{ route('blog.categories.destroy', $category) }}" method="POST"
                                            data-confirm="¿Eliminar la categoría «{{ $category->name }}»? Sus artículos pasarán a la categoría predeterminada.">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-table__action admin-table__action--danger"
                                                title="Eliminar">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="admin-table__action admin-table__action--disabled"
                                            title="No se puede eliminar la predeterminada">
                                            <i data-lucide="lock"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="admin-table__empty">
                                Todavía no hay categorías. Crea la primera con el formulario.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    @push('scripts')
        @vite('resources/js/admin/blog/categories/index.js')
    @endpush

@endsection
