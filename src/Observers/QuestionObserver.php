<?php

namespace TaylorNetwork\DynamicForm\Observers;

use TaylorNetwork\DynamicForm\Models\Question;

class QuestionObserver
{
    public function deleted(Question $question)
    {
        foreach($question->options as $option) {
            $option->delete();
        }
    }
}
