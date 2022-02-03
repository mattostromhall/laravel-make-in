# Laravel Make In

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mattostromhall/laravel-make-in.svg?style=flat-square)](https://packagist.org/packages/mattostromhall/laravel-make-in)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mattostromhall/laravel-make-in/run-tests?label=tests)](https://github.com/mattostromhall/laravel-make-in/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mattostromhall/laravel-make-in/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mattostromhall/laravel-make-in/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mattostromhall/laravel-make-in.svg?style=flat-square)](https://packagist.org/packages/mattostromhall/laravel-make-in)

A wrapper around the artisan make command to move created classes to a specified path and update the namespace accordingly. This is not needed if you follow the default folder structure of a laravel project as the make command itself provides this in the name argument of the command. 

However, if for instance you are following a Domain  Driven approach, this saves you manually moving the files and updating namespaces after creation.

## Installation

You can install the package via composer:

```bash
composer require mattostromhall/laravel-make-in
```

## Usage

The commands currently available are

```bash
php artisan make:command-in
php artisan make:controller-in
php artisan make:job-in
php artisan make:mail-in
php artisan make:model-in
php artisan make:request-in
```

The base path and namespace for a command can be set through your .env file by adding the following, with values for the base path and namespace you'd like to use for the command:
```bash
PATH_BASE_{CLASS_NAME}=path/to/base/location
NAMESPACE_BASE_{CLASS_NAME}=Base\Namespace\Here
```

Alternatively you can publish the config file and set the values you require there with:

```bash
php artisan vendor:publish --tag="laravel-make-in-config"
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Matt Ostrom-Hall](https://github.com/mattostromhall)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
