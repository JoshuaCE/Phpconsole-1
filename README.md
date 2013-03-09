# Phpconsole for Laravel

[Phpconsole](http://phpconsole.com/) is a new way to work with PHP and JS. Use it to debug, log and test your code in various situations. This package is a wrapper for interacting with Phpconsole in [Laravel 4](http://four.laravel.com/).

If you want to learn more about Phpconsole why don't you [take a tour](http://phpconsole.com/tour)?

## Installation

You can install Phpconsole for your Laravel 4 project through Composer.

Require the package in your `composer.json`.

```
"prologue/phpconsole": "dev-master"
```

Run composer to install or update the package.

```bash
$ composer update
```

Register the service provider in `app/config/app.php`.

```php
'Prologue\Phpconsole\PhpconsoleServiceProvider',
```

Add the alias to the list of aliases in `app/config/app.php`.

```php
'Phpconsole' => 'Prologue\Phpconsole\Facades\Phpconsole',
```

## Documentation

### Configuration

You can set users for Phpconsole at runtime but you can also add them in a package configuration file.

To create the configuration file run this command in your command line app:

```bash
$ php artisan config:publish prologue/phpconsole
```

The configuration file will be published here: `app/config/packages/prologue/phpconsole/config.php`.

You can add as many users as you like, as long as you use **unique nicknames** for each user.

### Adding users at runtime

In addition to setting users in the config file you can add them as well at runtime.

```php
Phpconsole::addUser('nickname', 'user_key', 'project_key');
```

If you use a nickname which has already been set, the previous user will be overwritten.

### Sending data

You can send strings and arrays to [phpconsole.com](http://phpconsole.com) by using the `send` function. Don't forget to add the user nickname as the second parameter.

```php
// Strings.
$string = 'test string';
Phpconsole::send($string, 'nickname');

// Arrays.
$array = array('foo' => array('bar', 'foo' => 'bar'), 'bar', 5);
Phpconsole::send($array, 'nickname');
```

### Using counters

You can increment counters on your Phpconsole project by using the `count` function. The first parameter is the counter identifier.

```php
Phpconsole::count(1, 'nickname'); // Counter 1 is increased by 1.
Phpconsole::count(2, 'nickname'); // Counter 2 is increased by 1.
```

### Automatic identification

You can automatically identify yourself as a user by setting a cookie through the `setUserCookie` function.

```php
Phpconsole::setUserCookie('nickname');
```

After setting the cookie you don't have to set the nickname parameter anymore for the `send` and `count` functions. The data will be automatically send to the user nickname which was set in the cookie.

```php
Phpconsole::send($data);
Phpconsole::count(1);
```

You can destroy a user cookie by using the `destroyUserCookie` setting.

```php
Phpconsole::destroyUserCookie('nickname');
```

### Default user

In addition to setting a user cookie yourself you can also let the package handle that. If you set the nickname for the default user in the config file, the package will register a user cookie for that user.

This is especially usefull for different environments. Say you have a development environment. You can set the default user to use your user settings in `app/config/packages/prologue/phpconsole/<environment>/config.php` so you can use the package functions without having to set the nickname everytime. In addition, every existing package function which doesn't sets a user nickname will send the data to your account.

## License

Phpconsole for Laravel is licensed under the [MIT License](http://opensource.org/licenses/MIT).