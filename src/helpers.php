<?php

if(!function_exists('get_form')) {

    function get_form_data(string $key)
    {
        return TaylorNetwork\DynamicForm\Models\Form::fetch($key);
    }

}