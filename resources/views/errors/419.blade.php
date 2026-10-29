{{-- Error 419: la página estuvo abierta mucho tiempo y su sesión expiró --}}
@extends('errors.layout')

@section('code', '419')
@section('heading', 'La página expiró')
@section('message', 'La página estuvo abierta mucho tiempo. Vuelve a ella e intenta de nuevo.')

@section('actions')
    <a href="{{ url()->previous() }}" class="error-page__btn error-page__btn--primary">
        Volver a la página
    </a>
@endsection
