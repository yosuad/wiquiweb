{{--
    Blog público — listado
    - Banner: el artículo principal (solo en "Todos", sin filtro).
    - Filtros: categorías con artículos publicados (?categoria=slug).
    - Grilla: artículos publicados, 9 por página.
    Datos: PageController@blog → $featured, $posts, $categories, $activeCategory
--}}

@extends('layouts.app')

@section('title', 'Blog')

@section('content')

    <!-- ════════════════ BLOG HERO ═══════════════ -->
    <section class="blog-hero">
        <div class="blog-hero__content">
            <p class="blog-hero__subtitle wow fadeInUp">Recursos y consejos</p>
            <h1 class="blog-hero__title wow fadeInUp">
                Nuestro <span class="blog-hero__highlight">Blog</span>
            </h1>
            <p class="blog-hero__text wow fadeInDown">
                Aprende sobre diseño web, marketing digital y tecnología<br>
                para hacer crecer tu negocio en línea
            </p>
        </div>
    </section>

    <!-- ════════════════ FILTROS ═══════════════ -->
    <section class="blog-filters">
        <div class="blog-filters__container">
            <ul class="blog-filters__list">
                <li>
                    <a href="{{ route('blog') }}"
                        class="blog-filters__tag {{ !$activeCategory ? 'blog-filters__tag--active' : '' }}">Todos</a>
                </li>
                @foreach ($categories as $category)
                    <li>
                        <a href="{{ route('blog', ['categoria' => $category->slug]) }}"
                            class="blog-filters__tag {{ $activeCategory?->id === $category->id ? 'blog-filters__tag--active' : '' }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    <!-- ════════════════ ARTÍCULO DESTACADO ═══════════════ -->
    {{-- Solo aparece en "Todos" y si hay un artículo marcado como principal --}}
    @if ($featured)
        <section class="blog-featured">
            <div class="blog-featured__container">
                <article class="blog-featured__card wow fadeInUp">
                    <div class="blog-featured__image-wrapper">
                        @if ($featured->featured_image)
                            <img src="{{ asset('uploads/' . $featured->featured_image) }}" alt="{{ $featured->title }}"
                                class="blog-featured__image">
                        @endif
                        <span class="blog-featured__badge">Destacado</span>
                    </div>
                    <div class="blog-featured__body">
                        <div class="blog-featured__meta">
                            <span class="blog-featured__category">{{ $featured->category->name }}</span>
                            <span class="blog-featured__dot">·</span>
                            <time class="blog-featured__date" datetime="{{ $featured->published_at->toDateString() }}">
                                {{ $featured->published_at->locale('es')->translatedFormat('j \d\e F, Y') }}
                            </time>
                            <span class="blog-featured__dot">·</span>
                            <span class="blog-featured__views">{{ number_format($featured->views) }} vistas</span>
                        </div>
                        <h2 class="blog-featured__title">
                            {{ $featured->title }}
                        </h2>
                        <p class="blog-featured__excerpt">
                            {{ $featured->excerpt }}
                        </p>
                        <div class="blog-featured__footer">
                            <div class="blog-featured__author">
                                <div class="blog-featured__author-avatar">
                                    <i data-lucide="user"></i>
                                </div>
                                <span class="blog-featured__author-name">{{ $featured->author->name }}</span>
                            </div>
                            <a href="{{ route('blog.post', $featured->slug) }}" class="blog-featured__link">
                                Leer artículo
                                <i class="blog-featured__link-icon" data-lucide="arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </article>
            </div>
        </section>
    @endif

    <!-- ════════════════ GRID DE ARTÍCULOS ═══════════════ -->
    <section class="blog-grid">
        <div class="blog-grid__container">

            <div class="blog-grid__header">
                <p class="blog-grid__subtitle">
                    {{ $activeCategory ? $activeCategory->name : 'Últimas publicaciones' }}
                </p>
                <h2 class="blog-grid__title">Más artículos del <span class="blog-grid__title-highlight">Blog</span></h2>
            </div>

            <div class="blog-grid__posts">

                @forelse ($posts as $post)
                    <article class="blog-post wow fadeInUp">
                        <a href="{{ route('blog.post', $post->slug) }}" class="blog-post__image-wrapper">
                            @if ($post->thumbnail_image)
                                <img src="{{ asset('uploads/' . $post->thumbnail_image) }}" alt="{{ $post->title }}"
                                    class="blog-post__image">
                            @endif
                            <span class="blog-post__category">{{ $post->category->name }}</span>
                        </a>
                        <div class="blog-post__body">
                            <div class="blog-post__meta">
                                <time class="blog-post__date" datetime="{{ $post->published_at->toDateString() }}">
                                    <i data-lucide="calendar" class="blog-post__meta-icon"></i>
                                    {{ $post->published_at->locale('es')->translatedFormat('j \d\e F, Y') }}
                                </time>
                                <span class="blog-post__views">
                                    {{ number_format($post->views) }}
                                    <i data-lucide="eye" class="blog-post__meta-icon"></i>
                                </span>
                            </div>
                            <h3 class="blog-post__title">
                                <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="blog-post__excerpt">
                                {{ $post->excerpt }}
                            </p>
                            <a href="{{ route('blog.post', $post->slug) }}" class="blog-post__link">
                                Leer más <i data-lucide="arrow-right" class="blog-post__link-icon"></i>
                            </a>
                        </div>
                    </article>
                @empty
                    <p class="blog-grid__empty">No hay blogs en esta categoría todavía.</p>
                @endforelse

            </div>

            <!-- Paginación (plantilla: views/vendor/pagination/blog.blade.php) -->
            @if ($posts->hasPages())
                <div class="blog-grid__pagination">
                    {{ $posts->links('vendor.pagination.blog') }}
                </div>
            @endif

        </div>
    </section>

    <!-- ════════════════ NEWSLETTER ═══════════════ -->
    <section class="blog-newsletter">
        <div class="blog-newsletter__container wow fadeInUp">
            <div class="blog-newsletter__icon">
                <i data-lucide="mail"></i>
            </div>
            <div class="blog-newsletter__body">
                <h2 class="blog-newsletter__title">Recibe los mejores artículos en tu correo</h2>
                <p class="blog-newsletter__text">Sin spam. Solo contenido útil para hacer crecer tu negocio digital.</p>
                <form class="blog-newsletter__form" action="{{ route('subscribers.store') }}" method="POST"
                    data-newsletter="blog-newsletter">
                    @csrf
                    <input type="email" name="email" class="blog-newsletter__input" placeholder="tucorreo@empresa.com"
                        required aria-label="Correo electrónico">
                    <button type="submit" class="blog-newsletter__btn">
                        Suscribirme
                        <i data-lucide="send" class="blog-newsletter__btn-icon"></i>
                    </button>
                </form>
            </div>
        </div>
    </section>

@endsection
