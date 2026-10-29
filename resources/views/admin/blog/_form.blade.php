{{-- Variables esperadas:
     $categories, $currentFeatured
     $post (solo en edit), $authors (solo en edit)
     $action: 'create' | 'edit'
--}}

@php
    $isEdit = $action === 'edit';
    $isFeatured = (string) (int) old('is_featured', $post->is_featured ?? false);
@endphp

<div class="post-form">

    <a href="{{ route('blog.index') }}" class="post-form__back">
        <i data-lucide="arrow-left"></i> Volver al blog
    </a>

    <form method="POST" action="{{ $isEdit ? route('blog.update', $post) : route('blog.store') }}"
        enctype="multipart/form-data" id="blog-post-form" data-upload-url="{{ route('blog.content-image') }}"
        data-initial-tags='@json(old('tags', isset($post) ? $post->tags->pluck('name')->toArray() : []))'>
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        <div class="post-form__grid">

            {{-- ── Columna principal ── --}}
            <div class="post-form__main">
                <div class="form-card">

                    {{-- Título --}}
                    <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" id="title" name="title"
                            value="{{ old('title', $post->title ?? '') }}" placeholder="Escribe el título del artículo"
                            class="form-input form-input--title">
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <p class="form-help">Déjalo vacío para generarlo automático a partir del título, o escribe
                            uno corto propio (solo letras, números, guiones y guiones bajos, sin espacios ni tildes).
                        </p>
                        <div class="slug-field">
                            <span class="slug-field__prefix">/blog/</span>
                            <input type="text" id="slug" name="slug"
                                value="{{ old('slug', $post->slug ?? '') }}" placeholder="ej: como-crear-una-pagina-web"
                                class="slug-field__input">
                        </div>
                        @error('slug')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="form-group">
                        <label for="category_id">Categoría</label>
                        <select id="category_id" name="category_id" class="form-input">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id ?? '') == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estado + Fecha (en una fila) --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Estado</label>
                            <select id="status" name="status" class="form-input">
                                <option value="draft" @selected(old('status', $post->status ?? 'draft') === 'draft')>Borrador</option>
                                <option value="published" @selected(old('status', $post->status ?? '') === 'published')>Publicada</option>
                            </select>
                            @error('status')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="published_at">Fecha de publicación</label>
                            <input type="datetime-local" id="published_at" name="published_at"
                                value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                class="form-input">
                            <p class="form-help">Vacía = la fecha en que se publique.</p>
                            @error('published_at')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    {{-- Autor (solo al editar) --}}
                    @if ($isEdit && isset($authors) && $authors->isNotEmpty())
                        <div class="form-group">
                            <label for="author_id">Autor</label>
                            <select id="author_id" name="author_id" class="form-input">
                                @foreach ($authors as $author)
                                    <option value="{{ $author->id }}" @selected(old('author_id', $post->author_id ?? '') == $author->id)>
                                        {{ $author->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('author_id')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif

                    {{-- Extracto --}}
                    <div class="form-group">
                        <label for="excerpt">Extracto</label>
                        <p class="form-help">Resumen corto que aparece en las tarjetas del blog y en redes sociales.</p>
                        <textarea id="excerpt" name="excerpt" rows="3" class="form-input" placeholder="Resumen breve...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                        @error('excerpt')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contenido (Quill) --}}
                    <div class="form-group">
                        <label>Contenido completo</label>
                        <p class="form-help">Usa el botón de imagen para insertar fotos en cualquier punto del texto,
                            y el botón de video para pegar un link de YouTube.</p>
                        <div id="content-editor"></div>
                        <input type="hidden" id="content" name="content"
                            value="{{ old('content', $post->content ?? '') }}">
                        @error('content')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Columna lateral ── --}}
            <aside class="post-form__sidebar">

                {{-- Artículo principal --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="star"></i> Artículo principal
                    </h3>
                    <select id="is_featured" name="is_featured" class="form-input">
                        <option value="0" @selected($isFeatured === '0')>No</option>
                        <option value="1" @selected($isFeatured === '1')>Sí, marcar como principal</option>
                    </select>
                    <p class="form-help">
                        @if ($isEdit && $post->is_featured)
                            Este es el artículo principal actual.
                        @elseif ($currentFeatured)
                            Hoy el artículo principal es: "{{ $currentFeatured->title }}". Si eliges Sí, lo reemplaza.
                        @else
                            Hoy no hay ningún artículo principal.
                        @endif
                    </p>
                    @error('is_featured')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Imagen destacada --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="image"></i> Imagen destacada
                    </h3>
                    <p class="form-help">JPG o PNG · 1200 × 630 px (1.9:1) · máx. 2 MB</p>
                    @if ($isEdit && $post->featured_image)
                        <img src="{{ asset('uploads/' . $post->featured_image) }}" alt="Imagen destacada actual"
                            class="post-form__preview">
                        <p class="form-help">Sube una nueva para reemplazarla.</p>
                    @endif
                    <input type="file" id="featured_image" name="featured_image" accept="image/*"
                        class="form-input">
                    @error('featured_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Imagen miniatura --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="image"></i> Imagen miniatura
                    </h3>
                    <p class="form-help">JPG o PNG · 800 × 450 px (16:9) · máx. 2 MB</p>
                    @if ($isEdit && $post->thumbnail_image)
                        <img src="{{ asset('uploads/' . $post->thumbnail_image) }}" alt="Miniatura actual"
                            class="post-form__preview post-form__preview--small">
                        <p class="form-help">Sube una nueva para reemplazarla.</p>
                    @endif
                    <input type="file" id="thumbnail_image" name="thumbnail_image" accept="image/*"
                        class="form-input">
                    @error('thumbnail_image')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Etiquetas --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="tag"></i> Etiquetas
                    </h3>
                    <p class="form-help">Escribe una etiqueta y pulsa Enter o coma para agregarla.</p>
                    <div class="tags-input">
                        <div class="tags-input__chips" id="tags-chips"></div>
                        <input type="text" id="tags-field" placeholder="Agrega etiquetas..."
                            class="tags-input__field">
                    </div>
                    <div id="tags-hidden"></div>
                    @error('tags')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Acciones --}}
                <div class="form-box">
                    <div class="form-actions form-actions--stacked">
                        <button type="submit" class="btn-primary">
                            <i data-lucide="save"></i>
                            {{ $isEdit ? 'Guardar cambios' : 'Crear artículo' }}
                        </button>
                        <a href="{{ route('blog.index') }}" class="btn-secondary">Cancelar</a>
                    </div>
                </div>

            </aside>

        </div>
    </form>
</div>

@push('scripts')
    @vite('resources/js/admin/blog/form.js')
@endpush
