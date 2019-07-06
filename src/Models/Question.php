<?php

namespace TaylorNetwork\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Question extends Model
{
    protected $guarded = [];

    protected $with = [ 'options' ];

    protected $appends = [ 'selectable', 'selectArgs', 'htmlId' ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function setTypeAttribute(string $type)
    {
        $this->attributes['type'] = strtolower($type);
    }

    public function getFormAttribute()
    {
        return $this->page->form;
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function addOption(string $text, $value = null)
    {
        if($this->selectable) {
            return $this->options()->create(compact('text', 'value'));
        }

        return false;
    }

    public function addOptions(array $options, bool $numericValues = false)
    {
        foreach($options as $index => $option) {
            if(gettype($option) === 'array') {
                $this->addOption($option['text'] ?? $option['option'], $option['value'] ?? null);
            } else {
                $this->addOption($option, (gettype($index) === 'string' || $numericValues) ? $index : null);
            }
        }

        return $this->options;
    }

    public function getSelectableAttribute()
    {
        return strstr($this->type, 'select');
    }

    public function getSelectArgsAttribute()
    {
        if($this->selectable) {
            return explode(' ', trim(str_replace('select', '', $this->type)));
        }

        return null;
    }

    public function getHtmlIdAttribute()
    {
        return Str::kebab(preg_replace('/[^a-z ]/', '', strtolower($this->question)));
    }
}
