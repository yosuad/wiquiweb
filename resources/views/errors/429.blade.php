{{-- Error 429: demasiadas solicitudes seguidas en poco tiempo --}}
@extends('errors.layout')

@section('code', '429')
@section('heading', 'Demasiadas solicitudes')
@section('message', 'Hiciste muchas solicitudes seguidas. Espera un momento e intenta de nuevo.')
