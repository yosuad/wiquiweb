{{-- Paginación del panel admin (diseño admin-pagination) --}}
@if ($paginator->hasPages())
    <div class="admin-pagination">
        <span class="admin-pagination__info">
            Mostrando {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} de {{ $paginator->total() }} resultados
        </span>

        <div class="admin-pagination__links">
            {{-- Anterior --}}
            @if ($paginator->onFirstPage())
                <span class="admin-pagination__link admin-pagination__link--disabled">
                    <i data-lucide="chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="admin-pagination__link" rel="prev">
                    <i data-lucide="chevron-left"></i>
                </a>
            @endif

            {{-- Números de página --}}
            @foreach ($elements as $element)
                {{-- Separador "..." --}}
                @if (is_string($element))
                    <span class="admin-pagination__link admin-pagination__link--disabled">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <a href="{{ $url }}"
                            class="admin-pagination__link {{ $page == $paginator->currentPage() ? 'admin-pagination__link--active' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach
                @endif
            @endforeach

            {{-- Siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="admin-pagination__link" rel="next">
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
