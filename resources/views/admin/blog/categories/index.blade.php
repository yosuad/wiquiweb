@extends('layouts.admin')

@section('title', 'Categorías del blog')

@section('content')

    @if ($errors->any())
        <script type="application/json" id="form-errors">{!! json_encode($errors->all()) !!}</script>
    @endif

    @if (session('status'))
        <script type="application/json" id="form-status">{!! json_encode(session('status')) !!}</script>
    @endif

    <div class="admin-page-header">
        <div>
            <a href="{{ route('blog.index') }}" class="post-form__back">
                <i data-lucide="arrow-left"></i> Volver al blog
            </a>
            <p class="admin-page-header__subtitle">Gestiona las categorías de los artículos del blog.</p>
        </div>
    </div>

    <div class="categorias-layout">

        {{-- Formulario para agregar --}}
        <div class="form-box">
            <h3 class="form-box__title">Agregar categoría</h3>

            <form method="POST" action="{{ route('blog.categorias.store') }}">
                @csrf
                <div class="form-group">
                    <label for="nombre" class="form-group__label">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Ej: Marketing digital"
                        class="form-group__input">
                    @error('nombre')
                        <span class="form-group__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="slug" class="form-group__label">Slug (opcional)</label>
                    <input type="text" id="slug" name="slug" placeholder="ej: marketing-digital"
                        class="form-group__input">
                    @error('slug')
                        <span class="form-group__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-box__actions">
                    <button type="submit" class="btn btn--primary btn--block">Crear categoría</button>
                </div>
            </form>
        </div>

        {{-- Listado --}}
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
                    @foreach ($categorias as $categoria)
                        <tr class="admin-table__row">
                            <td class="admin-table__title">{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->posts_count }}</td>
                            <td>
                                @if ($categoria->es_predeterminada)
                                    <span class="tag-badge tag-badge--principal">Predeterminada</span>
                                @else
                                    <form action="{{ route('blog.categorias.predeterminada', $categoria) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="admin-table__link-button">
                                            <i data-lucide="star" class="admin-table__link-button-icon"></i>
                                            Marcar como predeterminada
                                        </button>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <div class="admin-table__actions">
                                    <button type="button" class="admin-table__action js-editar-categoria" title="Editar"
                                        data-nombre="{{ $categoria->nombre }}"
                                        data-url="{{ route('blog.categorias.update', $categoria) }}">
                                        <i data-lucide="pencil"></i>
                                    </button>

                                    @if (!$categoria->es_predeterminada)
                                        <form action="{{ route('blog.categorias.destroy', $categoria) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="admin-table__action admin-table__action--danger js-eliminar-categoria"
                                                title="Eliminar">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="admin-table__action" style="opacity: 0.3; cursor: not-allowed;"
                                            title="No se puede eliminar la predeterminada">
                                            <i data-lucide="lock"></i>
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@endsection
