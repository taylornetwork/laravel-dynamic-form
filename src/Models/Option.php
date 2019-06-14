<?php

namespace TaylorNetwork\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $guarded = [];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getPageAttribute()
    {
        return $this->question->page;
    }

    public function getFormAttribute()
    {
        return $this->page->form;
    }
}
