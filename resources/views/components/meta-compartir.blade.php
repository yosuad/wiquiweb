{{-- Etiquetas para compartir enlaces (WhatsApp, Facebook, X).
     Uso: @include('components.meta-compartir', ['titulo' => ..., 'descripcion' => ..., 'imagen' => ...])
     Variables opcionales: $titulo, $descripcion, $imagen, $tipo (website | article) --}}
@php
    $metaTitulo = isset($titulo) ? $titulo . ' | wiquiweb' : 'wiquiweb';
    $metaDescripcion =
        $descripcion ??
        'Agencia especializada en diseño y desarrollo de páginas web para ayudar a tu empresa a destacar en internet.';
    $metaImagen = $imagen ?? asset('img/og-default.png');
    $metaTipo = $tipo ?? 'website';
@endphp
<meta property="og:type" content="{{ $metaTipo }}">
<meta property="og:site_name" content="wiquiweb">
<meta property="og:locale" content="es_CO">
<meta property="og:title" content="{{ $metaTitulo }}">
<meta property="og:description" content="{{ $metaDescripcion }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $metaImagen }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $metaTitulo }}">
<meta name="twitter:description" content="{{ $metaDescripcion }}">
<meta name="twitter:image" content="{{ $metaImagen }}">
