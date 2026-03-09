@extends('layouts.admin')

@section('title', 'Editar Servicio')

@php $pageTitle = 'Editar Servicio'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Editar servicio</p>
            <a href="{{ route('services.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver a servicios
            </a>
        </div>
    </div>

    <div class="form-container">
        <form method="POST" action="{{ route('services.update', $service->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nombre <span class="required">*</span></label>
                <input type="text" id="name" name="name"
                       value="{{ old('name', $service->name) }}"
                       class="form-input @error('name') is-invalid @enderror"
                       placeholder="Ej: Diseño Web, Hosting, SEO...">
                @error('name')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea id="description" name="description" rows="4"
                          class="form-input"
                          placeholder="Descripción del servicio (opcional)">{{ old('description', $service->description) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar servicio
                </button>
            </div>

        </form>
    </div>

@endsection