<?php

namespace TaylorNetwork\DynamicForm\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $guarded = [];

    protected $with = [ 'pages' ];

    public function pages()
    {
        return $this->hasMany(Page::class);
    }

    public function addPage(string $name = null)
    {
        $number = 1;

        if($this->pages->count()) {
            $number = ($this->pages->last()->number) + 1;
        }

        return $this->pages()->create([ 'number' => $number, 'name' => $name ]);
    }

    public function page(int $number = 1)
    {
        return $this->pages()->where('number', $number)->first();
    }

    public static function fetch(string $key): Form
    {
        try {
            return static::where('key', $key)->first();
        } catch (\Exception $e) {
            if(!config('dynamic_form.ignore_form_not_found', true)) {
                throw $e;
            }
        }
    }
}
