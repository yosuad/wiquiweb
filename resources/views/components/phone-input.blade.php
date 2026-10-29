{{--
    Campo de teléfono internacional (con bandera y selector de país).
    JS: js/components/phone-input.js | CSS: css/components/phone-input.css

    Uso:
        <x-phone-input name="whatsapp" class="form-input" placeholder="320 569 3258" required />
        <x-phone-input name="phone" :value="$contact->phone" class="form-input" />

    Props:
    - name:  nombre del campo que recibe el servidor (por defecto "whatsapp")
    - value: valor inicial (al editar); si hubo error de validación, se usa old()

    País inicial (en este orden):
    1. ?pais=mx en la URL (para forzarlo desde los anuncios de Meta)
    2. País del visitante según Cloudflare (cabecera CF-IPCountry)
    3. Colombia
    Cualquier otro atributo (class, id, placeholder, required…) se pasa al input.
--}}

@props([
    'name' => 'whatsapp',
    'value' => null,
])

@php
    $country = request('pais') ?: request()->header('CF-IPCountry') ?: 'CO';
@endphp

<input type="tel" name="{{ $name }}" value="{{ old($name, $value) }}" autocomplete="tel" data-phone-input
    data-country="{{ $country }}" {{ $attributes }}>
