# laravel-storyblok

[![Latest Version on Packagist](https://img.shields.io/packagist/v/takethelead/laravel-storyblok.svg?style=flat-square)](https://packagist.org/packages/takethelead/laravel-storyblok)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/takethelead/laravel-storyblok/run-tests?label=tests)](https://github.com/takethelead/laravel-storyblok/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/takethelead/laravel-storyblok.svg?style=flat-square)](https://packagist.org/packages/takethelead/laravel-storyblok)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require takethelead/laravel-storyblok
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --provider="TakeTheLead\LaravelStoryblok\LaravelStoryblokServiceProvider" --tag="migrations"
php artisan migrate
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="TakeTheLead\LaravelStoryblok\LaravelStoryblokServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$laravel-storyblok = new TakeTheLead\LaravelStoryblok();
echo $laravel-storyblok->echoPhrase('Hello, TakeTheLead!');
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

- [Joren Van Hocht](https://github.com/TakeTheLead)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
