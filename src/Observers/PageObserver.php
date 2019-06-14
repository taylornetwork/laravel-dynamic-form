<?php

namespace App\Observers;

use TaylorNetwork\DynamicForm\Models\Page;

class PageObserver
{
    public function deleted(Page $page)
    {
        foreach($page->questions as $question) {
            $question->delete();
        }
    }
}
