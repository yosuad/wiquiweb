@extends('layouts.admin')

@section('title', 'Nuevo artículo')

@php $pageTitle = 'Nuevo artículo'; @endphp

@section('content')
    @include('admin.blog._form', ['action' => 'create'])
@endsection
