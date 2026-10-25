@extends('layouts.admin')

@section('title', 'Editar artículo')

@section('content')
    @include('admin.blog._form', ['accion' => 'editar'])
@endsection
