{{-- Error 403: el usuario no tiene permiso para ver la página --}}
@extends('errors.layout')

@section('code', '403')
@section('heading', 'Acceso no permitido')
@section('message', 'No tienes permiso para ver esta página.')
