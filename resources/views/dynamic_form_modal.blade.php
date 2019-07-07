@php
    if(!isset($vue)) {
        $vue = 'dynamic-form';
    }

    if(!isset($route)) {
        $route = '/';
    }

    if(!isset($key) || !isset($id)) {
        throw new Exception('$key and $id are both required');
    }

    $data = get_form_data($key);
@endphp

@if($data)
    <{{ $vue }} id="{{ $id }}" :form-data="{{ $data }}" post-route="{{ $route }}"></{{ $vue }}>
@endif
