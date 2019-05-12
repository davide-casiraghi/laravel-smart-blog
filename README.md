# Laravel Smart blog

[![Latest Version on Packagist](https://img.shields.io/packagist/v/davide-casiraghi/laravel-smart-blog.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-smart-blog)
[![Build Status](https://img.shields.io/travis/davide-casiraghi/laravel-smart-blog/master.svg?style=flat-square)](https://travis-ci.org/davide-casiraghi/laravel-smart-blog)
[![Quality Score](https://img.shields.io/scrutinizer/g/davide-casiraghi/laravel-smart-blog.svg?style=flat-square)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-smart-blog)
[![Coverage Status](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-smart-blog/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/davide-casiraghi/laravel-smart-blog/)
<a href="https://codeclimate.com/github/davide-casiraghi/laravel-smart-blog/maintainability"><img src="https://api.codeclimate.com/v1/badges/ebfe603df3c163cee1f6/maintainability" /></a>
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/laravel-smart-blog.svg)](https://github.com/davide-casiraghi/laravel-smart-blog) 


A multi language blog package for Laravel.

## Installation

You can install the package via composer:

```bash
composer require davide-casiraghi/laravel-smart-blog
```
Then install Bricklayer.js trough npm
```bash
npm install bricklayer  
```


## Load the CSS and JS files

### With Laravel

#### Publish the JS, CSS and IMAGES
It's possible to customize the scss and the js publishing them in your Laravel application.  

```php artisan vendor:publish```

This command will publish in your application this folders:
- /resources/scss/vendor/laravel-smart-blog/
- /resources/js/vendor/laravel-smart-blog/

In this way it's possible for you to customize them.


#### Run the migration

```php artisan migrate ```   

To create the gallery_images table in your database.

#### Load the JS file

In the **resources/js/app.js** file of your application require the **Bricklayer** and **bricklayerBlogLayout.js** files before the Vue object get instanciated:

```
require('./bootstrap');
window.Vue = require('vue');

window.Bricklayer = require('bricklayer');
require('./vendor/laravel-smart-blog/bricklayerBlogLayout');

window.myApp = new Vue({  
    el: '#app'
});
```

In the **resources/sass/app.scss** file of your application import the scss
```
@import 'vendor/laravel-smart-blog/bricklayerBlogLayout';
```

Then you can run Laravel Mix
```
npm run dev
```

## Usage

``` php
// Usage description here
```

### Testing

You can run unit tests checking the code coverage using this command.

``` bash
./vendor/bin/phpunit --coverage-html=html 
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email davide.casiraghi@gmail.com instead of using the issue tracker.

## Credits

- [Davide Casiraghi](https://github.com/davide-casiraghi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
