# Laravel Dynamic Form

## Install

```bash
$ composer require taylornetwork/laravel-dynamic-form
```

## Setup

Run migrations

```bash
$ php artisan migrate
```

## VueJS Setup

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

