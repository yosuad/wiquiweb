@extends('layouts.app')

@section('title', 'Cancelar suscripción — Wiquiweb')

@section('content')

<main class="unsub">
    <div class="unsub__card">

        @if(session('success'))
            {{-- Baja exitosa --}}
            <div class="unsub__success">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <h1 class="unsub__title">Te has dado de baja</h1>
            </div>
            <p class="unsub__text">Tu correo ha sido removido de nuestra lista. Ya no recibirás más correos de Wiquiweb.</p>
            <a href="{{ route('home') }}" class="unsub__btn unsub__btn--primary">Volver al inicio</a>

        @elseif($subscriber && $subscriber->status === 'unsubscribed')
            {{-- Ya estaba dado de baja --}}
            <div class="unsub__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="12"></line>
                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                </svg>
            </div>
            <h1 class="unsub__title">Ya estás dado de baja</h1>
            <p class="unsub__text">Este correo ya fue removido de nuestra lista anteriormente.</p>
            <a href="{{ route('home') }}" class="unsub__btn unsub__btn--primary">Volver al inicio</a>

        @else
            {{-- Formulario de baja --}}
            <div class="unsub__icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="1.5"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                    <polyline points="22,6 12,13 2,6"></polyline>
                </svg>
            </div>

            <h1 class="unsub__title">Cancelar suscripción</h1>
            <p class="unsub__text">¿Deseas dejar de recibir correos de Wiquiweb? Confirma tu email para darte de baja.</p>

            @if($errors->has('email'))
                <p class="unsub__error">{{ $errors->first('email') }}</p>
            @endif

            <form class="unsub__form" method="POST" action="{{ route('subscribers.unsubscribe') }}">
                @csrf
                <input type="email" name="email"
                    value="{{ old('email', $email) }}"
                    class="unsub__input"
                    placeholder="tu@correo.com"
                    required
                    {{ $email ? 'readonly' : '' }}>
                <button type="submit" class="unsub__btn unsub__btn--danger">
                    Darme de baja
                </button>
            </form>

            <a href="{{ route('home') }}" class="unsub__cancel">Cancelar — volver al inicio</a>
        @endif

    </div>
</main>

@endsection