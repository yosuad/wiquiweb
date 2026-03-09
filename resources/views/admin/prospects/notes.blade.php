@extends('layouts.admin')

@section('title', 'Notas del prospecto')

@php $pageTitle = 'Notas'; @endphp

@section('content')

    <div class="dashboard__title-section">
        <div class="dashboard__title-row">
            <p class="dashboard__page-desc">Historial de seguimiento — {{ $prospect->name }}</p>
            <a href="{{ $from === 'lost' ? route('prospects.lost') : route('prospects.index') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    {{-- Formulario para agregar nota --}}
    <div class="form-container" style="margin-bottom: 1.5rem;">
        <form method="POST" action="{{ route('prospects.notes.store', $prospect->id) }}">
            @csrf
            <input type="hidden" name="from" value="{{ $from }}">
            <div class="form-group">
                <label for="note">Nueva nota</label>
                <textarea id="note" name="note" rows="3"
                          class="form-input @error('note') is-invalid @enderror"
                          placeholder="Escribe una nota de seguimiento...">{{ old('note') }}</textarea>
                @error('note')
                    <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-plus"></i> Agregar nota
                </button>
            </div>
        </form>
    </div>

    {{-- Historial de notas --}}
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nota</th>
                    <th>Escrita por</th>
                    <th>Fecha</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notes as $note)
                    <tr>
                        <td>{{ $note->note }}</td>
                        <td>{{ $note->author->name ?? '—' }}</td>
                        <td>{{ $note->created_at->format('Y-m-d H:i') }}</td>
                        <td class="td-actions">
                            <form method="POST" action="{{ route('prospects.notes.destroy', [$prospect->id, $note->id]) }}">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="from" value="{{ $from }}">
                                <button class="btn-action btn-delete" title="Eliminar">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No hay notas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection