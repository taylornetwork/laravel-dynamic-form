<?php

namespace TaylorNetwork\DynamicForm\Observers;

use TaylorNetwork\DynamicForm\Models\Form;

class FormObserver
{
    public function deleted(Form $form)
    {
        foreach($form->pages as $page) {
            $page->delete();
        }
    }
}
