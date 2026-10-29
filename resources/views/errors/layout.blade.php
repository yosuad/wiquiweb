{{--
    PÁGINAS DE ERROR — Plantilla común
    Cada página de error (403, 404, 419…) define:
    - @section('code')     → el número grande (ej: 404)
    - @section('heading')  → el título (ej: Página no encontrada)
    - @section('message')  → la explicación
    - @section('actions')  → los botones (opcional; por defecto "Volver al inicio")
    CSS: css/errors/layout.css
--}}

@extends('layouts.app')

@section('title', View::getSection('code') . ' - ' . View::getSection('heading'))

@section('content')
    <main class="error-page">
        <div class="error-page__container">
            <h1 class="error-page__title">@yield('code')</h1>
            <h2 class="error-page__subtitle">@yield('heading')</h2>
            <p class="error-page__text">@yield('message')</p>
            <div class="error-page__actions">
                @hasSection('actions')
                    @yield('actions')
                @else
                    <a href="{{ url('/') }}" class="error-page__btn error-page__btn--primary">
                        Volver al inicio
                    </a>
                @endif
            </div>
        </div>
    </main>
@endsection
