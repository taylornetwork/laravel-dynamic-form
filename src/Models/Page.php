<?php

namespace TaylorNetwork\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    protected $with = [ 'questions' ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function addQuestion(string $question, string $type = 'text', bool $required = true)
    {
        return $this->questions()->create(compact('question', 'type', 'required'));
    }

    public function addQuestions(array $questions)
    {
        foreach($questions as $question) {
            if(gettype($question) === 'array') {
                $this->addQuestion($question['question'], $question['type'] ?? 'text', $question['required'] ?? true);
            } else {
                $this->addQuestion($question);
            }
        }

        return $this->questions;
    }
}
