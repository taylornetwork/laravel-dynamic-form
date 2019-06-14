<?php

namespace TaylorNetwork\DynamicForm;

use TaylorNetwork\DynamicForm\Observers\FormObserver;
use TaylorNetwork\DynamicForm\Observers\PageObserver;
use TaylorNetwork\DynamicForm\Observers\QuestionObserver;
use Illuminate\Support\ServiceProvider;
use TaylorNetwork\DynamicForm\Models\Form;
use TaylorNetwork\DynamicForm\Models\Page;
use TaylorNetwork\DynamicForm\Models\Question;

class DynamicFormProvider extends ServiceProvider
{
    public function boot()
    {
        include_once __DIR__.'/helpers.php';

        Form::observe(FormObserver::class);
        Page::observe(PageObserver::class);
        Question::observe(QuestionObserver::class);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'form-migrations');


        $this->publishes([
            __DIR__.'/../resources/js/components' => base_path('resources/js/components'),
        ], 'form-components');
    }

}