@extends('layouts.app')
@section('title', '404 - Página no encontrada')

@section('content')  
    <main class="error404">
        <div class="error404__container">
            <h1 class="error404__title">404</h1>
            <h2 class="error404__subtitle">
                Página no encontrada
            </h2>
            <p class="error404__text">
                Lo sentimos, la página que estás buscando no existe o fue movida.
            </p>
            <div class="error404__actions">
                <a href="{{ url('/') }}" class="error404__btn error404__btn--primary">
                    Volver al inicio
                </a>
            </div>
        </div>
    </main>
@endsection