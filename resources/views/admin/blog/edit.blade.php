@extends('layouts.admin')

@section('title', 'Editar artículo')

@php $pageTitle = 'Editar artículo'; @endphp

@section('content')
    @include('admin.blog._form', ['action' => 'edit'])
@endsection
