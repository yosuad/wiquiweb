{{--
    Paginación del blog público (diseño blog-pagination)
    Uso: {{ $posts->links('vendor.pagination.blog') }}
    El contenedor .blog-grid__pagination lo pone la vista del blog.
    CSS: css/site/blog/index.css → sección PAGINACIÓN
--}}

@if ($paginator->hasPages())

    {{-- Anterior: solo aparece si no estamos en la primera página --}}
    @unless ($paginator->onFirstPage())
        <a href="{{ $paginator->previousPageUrl() }}" class="blog-pagination__btn blog-pagination__btn--prev" rel="prev"
            aria-label="Página anterior">
            <i data-lucide="chevron-left"></i>
        </a>
    @endunless

    {{-- Números de página --}}
    @foreach ($elements as $element)
        {{-- Separador "…" cuando hay muchas páginas --}}
        @if (is_string($element))
            <span class="blog-pagination__dots">…</span>
        @endif

        @if (is_array($element))
            @foreach ($element as $page => $url)
                <a href="{{ $url }}"
                    class="blog-pagination__page {{ $page == $paginator->currentPage() ? 'blog-pagination__page--active' : '' }}"
                    @if ($page == $paginator->currentPage()) aria-current="page" @endif>
                    {{ $page }}
                </a>
            @endforeach
        @endif
    @endforeach

    {{-- Siguiente: solo aparece si hay más páginas --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="blog-pagination__btn blog-pagination__btn--next" rel="next"
            aria-label="Página siguiente">
            <i data-lucide="chevron-right"></i>
        </a>
    @endif

@endif
