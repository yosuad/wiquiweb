@extends('layouts.admin')

@section('title', 'Nuevo artículo')

@section('content')
    @include('admin.blog._form', ['accion' => 'crear'])
@endsection
