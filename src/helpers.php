<?php

if(!function_exists('get_form_data')) {

    function get_form_data(string $key)
    {
        return TaylorNetwork\DynamicForm\Models\Form::fetch($key);
    }

}

if(!function_exists('render_vue_modal')) {

    function render_vue_modal(string $id, string $key, string $route = '/', string $vue = 'dynamic-form')
    {
        return view('dynamic_form.dynamic_form_modal', compact('id', 'key', 'route', 'vue'));
    }

}