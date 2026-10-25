{{-- Variables esperadas:
     $categorias, $cupos
     $post (solo en edit), $autores (solo en edit como administrator)
     $accion: 'crear' | 'editar'
--}}

@php
    $esEditar = $accion === 'editar';
    $esGestor = auth()->user()->hasRole('administrator');
@endphp

{{-- Alertas de validación --}}
@if ($errors->any())
    <div class="form-alertas">
        <ul class="form-alertas__list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('status'))
    <div class="form-alertas form-alertas--ok">{{ session('status') }}</div>
@endif

<div class="post-form">

    {{-- Header --}}
    <div class="admin-page-header">
        <div>
            <a href="{{ route('blog.index') }}" class="post-form__back">
                <i data-lucide="arrow-left"></i> Volver al blog
            </a>
            <h2 class="admin-page-header__title">
                {{ $esEditar ? 'Editar artículo' : 'Nuevo artículo' }}
            </h2>
        </div>
    </div>

    <form method="POST" action="{{ $esEditar ? route('blog.update', $post) : route('blog.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if ($esEditar)
            @method('PUT')
        @endif

        <div class="post-form__grid">

            {{-- ── Columna principal ── --}}
            <div class="post-form__main">
                <div class="form-card">

                    {{-- Título --}}
                    <div class="form-group">
                        <label for="titulo" class="form-group__label">Título</label>
                        <input type="text" id="titulo" name="titulo"
                            value="{{ old('titulo', $post->titulo ?? '') }}"
                            placeholder="Escribe el título del artículo"
                            class="form-group__input form-group__input--title">
                        @error('titulo')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Slug --}}
                    <div class="form-group">
                        <label for="slug" class="form-group__label">Slug (URL)</label>
                        <p class="form-group__help">Déjalo vacío para generarlo automático a partir del título, o
                            escribe
                            uno corto propio (solo letras, números, guiones y guiones bajos, sin espacios ni tildes).
                        </p>
                        <div class="slug-field">
                            <span class="slug-field__prefix">/blog/</span>
                            <input type="text" id="slug" name="slug"
                                value="{{ old('slug', $post->slug ?? '') }}" placeholder="ej: como-crear-una-pagina-web"
                                class="slug-field__input">
                        </div>
                        @error('slug')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div class="form-group">
                        <label for="categoria_id" class="form-group__label">Categoría</label>
                        <select id="categoria_id" name="categoria_id" class="form-group__select">
                            <option value="">Selecciona una categoría</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}" @selected(old('categoria_id', $post->categoria_id ?? '') == $categoria->id)>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Estado y fecha (solo gestor) --}}
                    @if ($esGestor)
                        <div class="form-group">
                            <label for="estado" class="form-group__label">Estado</label>
                            <select id="estado" name="estado" class="form-group__select">
                                <option value="borrador" @selected(old('estado', $post->estado ?? 'borrador') === 'borrador')>Borrador</option>
                                <option value="revision" @selected(old('estado', $post->estado ?? '') === 'revision')>En revisión</option>
                                <option value="publicada" @selected(old('estado', $post->estado ?? '') === 'publicada')>Publicada</option>
                            </select>
                            @error('estado')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="published_at" class="form-group__label">Fecha de publicación</label>
                            <p class="form-group__help">Déjala vacía para usar la fecha actual.</p>
                            <input type="datetime-local" id="published_at" name="published_at"
                                value="{{ old('published_at', isset($post->published_at) ? $post->published_at->format('Y-m-d\TH:i') : '') }}"
                                class="form-group__input">
                            @error('published_at')
                                <span class="form-group__error">{{ $message }}</span>
                            @enderror
                        </div>

                        @if ($esEditar && isset($autores) && $autores->isNotEmpty())
                            <div class="form-group">
                                <label for="autor_id" class="form-group__label">Autor</label>
                                <select id="autor_id" name="autor_id" class="form-group__select">
                                    @foreach ($autores as $autor)
                                        <option value="{{ $autor->id }}" @selected(old('autor_id', $post->autor_id ?? '') == $autor->id)>
                                            {{ $autor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('autor_id')
                                    <span class="form-group__error">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                    @endif

                    {{-- Extracto --}}
                    <div class="form-group">
                        <label for="extracto" class="form-group__label">Extracto</label>
                        <p class="form-group__help">Resumen corto que aparece en las tarjetas del blog y en redes
                            sociales.</p>
                        <textarea id="extracto" name="extracto" rows="3" class="form-group__textarea" placeholder="Resumen breve...">{{ old('extracto', $post->extracto ?? '') }}</textarea>
                        @error('extracto')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contenido (Quill) --}}
                    <div class="form-group">
                        <label class="form-group__label">Contenido completo</label>
                        <p class="form-group__help">Usa el botón de imagen para insertar fotos en cualquier punto del
                            texto, y el botón de video para pegar un link de YouTube.</p>
                        <div id="contenido-editor"></div>
                        <input type="hidden" id="contenido" name="contenido"
                            value="{{ old('contenido', $post->contenido ?? '') }}">
                        @error('contenido')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- ── Sidebar ── --}}
            <aside class="post-form__sidebar">

                {{-- Posición destacada (solo gestor) --}}
                @if ($esGestor)
                    <div class="form-box">
                        <h3 class="form-box__title form-box__title--icon">
                            <i data-lucide="star"></i> Posición en el home
                        </h3>
                        <p class="form-group__help">Si eliges una posición ocupada, se le quitará al artículo actual.
                        </p>
                        @php
                            $valorActual =
                                isset($post) && $post->destacada_estado === 'destacada'
                                    ? 'destacada_' . $post->destacada_orden
                                    : 'ninguna';
                        @endphp
                        <select id="destacada_estado" name="destacada_estado" class="form-group__select">
                            <option value="ninguna" @selected(old('destacada_estado', $valorActual) === 'ninguna')>
                                Ninguna
                            </option>
                            @foreach ([1, 2, 3] as $n)
                                <option value="destacada_{{ $n }}" @selected(old('destacada_estado', $valorActual) === 'destacada_' . $n)>
                                    Destacada #{{ $n }}
                                    {{ $cupos['destacada_' . $n] ? '— ocupa: ' . $cupos['destacada_' . $n]->titulo : '(libre)' }}
                                </option>
                            @endforeach
                        </select>
                        @error('destacada_estado')
                            <span class="form-group__error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                {{-- Imagen destacada --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="image"></i> Imagen destacada
                    </h3>
                    <p class="form-group__help">JPG o PNG · 1200 × 630 px (1.9:1) · máx. 2 MB</p>
                    @if ($esEditar && $post->imagen_destacada)
                        <div class="form-imagen__preview">
                            <img src="{{ asset('uploads/' . $post->imagen_destacada) }}"
                                alt="Imagen destacada actual">
                            <p class="form-group__help">Sube una nueva para reemplazarla.</p>
                        </div>
                    @endif
                    <input type="file" id="imagen_destacada" name="imagen_destacada" accept="image/*"
                        class="form-group__input">
                    @error('imagen_destacada')
                        <span class="form-group__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Imagen miniatura --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="image"></i> Imagen miniatura
                    </h3>
                    <p class="form-group__help">JPG o PNG · 800 × 450 px (16:9) · máx. 2 MB</p>
                    @if ($esEditar && $post->imagen_miniatura)
                        <div class="form-imagen__preview form-imagen__preview--small">
                            <img src="{{ asset('uploads/' . $post->imagen_miniatura) }}" alt="Miniatura actual">
                            <p class="form-group__help">Sube una nueva para reemplazarla.</p>
                        </div>
                    @endif
                    <input type="file" id="imagen_miniatura" name="imagen_miniatura" accept="image/*"
                        class="form-group__input">
                    @error('imagen_miniatura')
                        <span class="form-group__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Etiquetas --}}
                <div class="form-box">
                    <h3 class="form-box__title form-box__title--icon">
                        <i data-lucide="tag"></i> Etiquetas
                    </h3>
                    <p class="form-group__help">Escribe una etiqueta y pulsa Enter o coma para agregarla.</p>
                    <div class="etiquetas-field" id="etiquetas-field">
                        <div class="etiquetas-field__tags" id="etiquetas-tags"></div>
                        <input type="text" id="etiquetas-input" placeholder="Agrega etiquetas..."
                            class="etiquetas-field__input">
                    </div>
                    <div id="etiquetas-hidden"></div>
                    @error('etiquetas')
                        <span class="form-group__error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Acciones --}}
                <div class="form-box form-box--actions">
                    <button type="submit" class="btn btn--primary btn--full">
                        <i data-lucide="save" class="btn__icon"></i>
                        {{ $esEditar ? 'Guardar cambios' : 'Crear artículo' }}
                    </button>
                    <a href="{{ route('blog.index') }}" class="btn btn--secondary btn--full">
                        Cancelar
                    </a>
                </div>

            </aside>

        </div>
    </form>
</div>

@push('scripts')
    <script>
        // ── Etiquetas ──────────────────────────────────────────────────────────
        const etiquetasIniciales = @json(isset($post) ? $post->etiquetas->pluck('nombre')->toArray() : old('etiquetas') ?? []);

        const tagsContainer = document.getElementById('etiquetas-tags');
        const hiddenContainer = document.getElementById('etiquetas-hidden');
        const etiquetaInput = document.getElementById('etiquetas-input');
        let tags = [...etiquetasIniciales];

        function renderTags() {
            tagsContainer.innerHTML = '';
            hiddenContainer.innerHTML = '';
            tags.forEach((tag, i) => {
                const span = document.createElement('span');
                span.className = 'etiquetas-field__tag';
                span.innerHTML =
                    `${tag} <button type="button" data-index="${i}" class="etiquetas-field__remove">&times;</button>`;
                tagsContainer.appendChild(span);

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'etiquetas[]';
                hidden.value = tag;
                hiddenContainer.appendChild(hidden);
            });
        }

        tagsContainer.addEventListener('click', (e) => {
            if (e.target.classList.contains('etiquetas-field__remove')) {
                tags.splice(Number(e.target.dataset.index), 1);
                renderTags();
            }
        });

        etiquetaInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                const val = etiquetaInput.value.trim().replace(/,$/, '');
                if (val && !tags.includes(val)) {
                    tags.push(val);
                    renderTags();
                }
                etiquetaInput.value = '';
            }
        });

        renderTags();

        // ── Quill ──────────────────────────────────────────────────────────────
        const quill = new Quill('#contenido-editor', {
            theme: 'snow',
            placeholder: 'Escribe el contenido del artículo...',
            modules: {
                toolbar: {
                    container: [
                        [{
                            header: [2, 3, false]
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['blockquote', 'code-block'],
                        ['link', 'image', 'video'],
                        ['clean'],
                    ],
                    handlers: {
                        image: function() {
                            const fileInput = document.createElement('input');
                            fileInput.setAttribute('type', 'file');
                            fileInput.setAttribute('accept', 'image/*');
                            fileInput.click();
                            fileInput.onchange = async () => {
                                const file = fileInput.files[0];
                                const formData = new FormData();
                                formData.append('imagen', file);
                                formData.append('_token', document.querySelector(
                                    'meta[name="csrf-token"]')?.content ?? '');

                                const res = await fetch('{{ route('blog.imagen-contenido') }}', {
                                    method: 'POST',
                                    body: formData
                                });
                                const data = await res.json();
                                const range = quill.getSelection();
                                quill.insertEmbed(range.index, 'image', data.url);
                            };
                        },
                    },
                },
            },
        });

        const contenidoHidden = document.getElementById('contenido');
        if (contenidoHidden.value) {
            quill.root.innerHTML = contenidoHidden.value;
        }

        document.querySelector('form').addEventListener('submit', () => {
            contenidoHidden.value = quill.root.innerHTML;
        });
    </script>
@endpush
