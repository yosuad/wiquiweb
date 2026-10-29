{{-- Error 500: falla interna del servidor --}}
@extends('errors.layout')

@section('code', '500')
@section('heading', 'Algo salió mal')
@section('message', 'Tuvimos un problema al cargar esta página. Ya estamos revisando.')
