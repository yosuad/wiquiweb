{{-- Error 503: sitio en mantenimiento (php artisan down) --}}
@extends('errors.layout')

@section('code', '503')
@section('heading', 'Estamos en mantenimiento')
@section('message', 'Estamos haciendo mejoras en el sitio. Volvemos en unos minutos.')

@section('actions')
    <a href="{{ url()->current() }}" class="error-page__btn error-page__btn--primary">
        Recargar
    </a>
@endsection
