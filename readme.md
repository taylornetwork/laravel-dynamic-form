# Laravel Dynamic Form

This package lets you dynamically create forms for a Laravel application that can be easily filled out by a user. 

I created this package to have better control over user form pages, questions and options. 

*Note: both the package and readme are still a work in progress*

## Install

```bash
$ composer require taylornetwork/laravel-dynamic-form
```

## Setup

Run migrations

```bash
$ php artisan migrate
```

## Models

All models are in the namespace `TaylorNetwork\DynamicForm\Models`

### Form

The `Form` model allows you to define a form `key` and `title` and will provide all related models below. 

### Page

The `Page` model allows you to define pages on the form. This can be useful if you have a lot of questions to ask the user. Forms need at least 1 page.

Pages are numbered automatically when you use the `addPage` method (see Usage below)

Pages can have a title that will be displayed to the user.

### Question

The `Question` model is the actual question that will be shown to the user. You can specify the a few different question types.

**Currently supported types**

- `text` (default)
- `textarea`
- `select`
- `select multiple`
- `select multiple taggable` (select multiple but can include user defined values)

### Option

The `Option` model is only used if the question type is one that includes `select`. It allows you to set options to be used for the select controls

## Usage

For example you want to create a multiple page form that asks the user about themselves and their home.

#### Create a new form

```php
Form::create([ 'key' => 'user-info', 'title' => 'User Information Form' ]);
```

#### Fetch a form by key

You can use the `fetch` method on the `Form` model to fetch a form by key or you can use the `get_form_data` helper function.

```php
Form::fetch('user-info');

get_form_data('user-info');
```

#### Add a page

Use the `addPage` method to add a new page to a form. Forms need at least 1 page. The `addPage` method will automatically increment the page numbers. It accepts an optional parameter that is the title of the page.

```php
Form::fetch('user-info')->addPage('Information about you');

Form::fetch('user-info')->addPage();
```

#### Add questions

Use the `addQuestion` method to add a question to a page of a form. 

```php
Form::fetch('user-info')->page(1)->addQuestion('What is your name?');

Form::fetch('user-info')->page(1)->addQuestion('What is your email address?');

Form::fetch('user-info')->page(1)->addQuestion('Tell us something interesting about you?', 'textarea');
```

#### Add questions with options

Basic options: 

For basic options that the values to pass back are the same as the text shown to the user, use the `addOptions` method and pass an array to a question.

```php
Form::fetch('user-info')->page(1)->addQuestion('Are you the home owner?', 'select')->addOptions([ 'Yes', 'No' ]);

Form::fetch('user-info')->page(1)->addQuestion('What colours are in your home?', 'select multiple taggable')->addOptions([ 'Yellow', 'Blue', 'Red' ]);
```

Options with different values:

For options that the values passed back are different than the text shown to the user, use the `addOption` method and pass the text as the first parameter and the value as the second.

The `addOption` method returns an instance of the `Option` model so you cannot chain multiple together.

```php
$question = Form::fetch('user-info')->page(1)->addQuestion('What rooms need work?', 'select multiple');

$question->addOption('Bathroom', 'BATH');
$question->addOption('Living Room', 'LVRM');
$question->addOption('Bedroom', 'BDRM');
$question->addOption('Basement', 'BSMT');
```


## VueJS Setup

If you want to use the VueJS modal included

Install required NPM dependencies

```bash
$ npm install --save vue-select sweetalert2
```

Publish VueJS component

```bash
$ php artisan vendor:publish --tag=form-components
```

Add the following line to your `resources/js/app.js` somewhere after `window.Vue = require('vue');`

```js
Vue.component('dynamic-form', require('./components/DynamicForm.vue').default);
```

## VueJS Usage

The Vue modal has 3 required props 

- `id`: The modal ID, used to open the modal
- `form-data`: The actual form data, you can use the `get_form_data()` helper
- `post-route`: The route to post the saved data to

When the data is submitted the component will use make an `axios` POST request to the uri from `post-route`.

The POST data will be an object with keys being the `id` of the question and the value being the data entered. If using `select multiple` this will be an array if more than one item is selected.


### Basic Example

```php
<button class="btn btn-outline-secondary" data-toggle="modal" data-target="#dynForm">Open Modal</button>

<dynamic-form id="dynForm" 
				 :form-data="{{ get_form_data('user-info') }}" 
				 post-route="{{ route('api.dynamic.form.store') }}">
</dynamic-form>
```

Note: When passing the form data to the Vue component be sure to include the `:` to bind the data. T

#### Example POST Data

Based on example above.

```js
{
	1: 'John Doe',
	2: 'johndoe@example.com',
	3: 'John Doe is not my real name.',
	4: 'Yes',
	5: [ 
			'Blue',
			'Red'
		],
	6: 'BDRM'
}
```




