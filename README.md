# Phpconsole for Laravel

[Phpconsole](http://phpconsole.com/) is a new way to work with PHP and JS. Use it to debug, log and test your code in various situations. This package is a wrapper for interacting with Phpconsole in [Laravel 4](http://four.laravel.com/).

If you want to learn more about Phpconsole why don't you [take a tour](http://phpconsole.com/tour)?

## Installation

You can install Phpconsole for your Laravel 4 project through Composer.

Require the package in your `composer.json`.

	"prologue/phpconsole": "dev-master"

Run composer to install or update the package.

	$ composer update

Register the service provider in `app/config/app.php`.

```php
'Prologue\Phpconsole\PhpconsoleServiceProvider',
```

Add the alias to the list of aliases in `app/config/app.php`.

```php
'Phpconsole' => 'Prologue\Phpconsole\Facades\Phpconsole',
```

## Documentation

Documentation coming soon!

## License

Phpconsole for Laravel is licensed under the [MIT License](http://opensource.org/licenses/MIT).