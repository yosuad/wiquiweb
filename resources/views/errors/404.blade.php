{{-- Error 404: la página no existe o fue movida --}}
@extends('errors.layout')

@section('code', '404')
@section('heading', 'Página no encontrada')
@section('message', 'Lo sentimos, la página que estás buscando no existe o fue movida.')
