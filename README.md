# Laravel Storyblok

[![Latest Version on Packagist](https://img.shields.io/packagist/v/takethelead/laravel-storyblok.svg?style=flat-square)](https://packagist.org/packages/takethelead/laravel-storyblok)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/takethelead/laravel-storyblok/Tests?label=tests)](https://github.com/takethelead/laravel-storyblok/actions?query=workflow%3ATests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/takethelead/laravel-storyblok.svg?style=flat-square)](https://packagist.org/packages/takethelead/laravel-storyblok)

Laravel storyblok is a wrapper around the [official Storyblok php client](https://github.com/storyblok/php-client) with some extra Laravel perks.

## Installation

You can install the package via composer:

```bash
composer require takethelead/laravel-storyblok
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="TakeTheLead\LaravelStoryblok\LaravelStoryblokServiceProvider" --tag="config"
```

This is the contents of the published config file:

```php
return [

    /**
     * The api key used to authenticated with the Storyblok api.
     */
    'api_key' => env('STORYBLOK_API_KEY'),

    /**
     * Cache Storyblok api responses.
     */
    'enable_local_cache' => env('STORYBLOK_ENABLE_LOCAL_CACHE', true),

    /**
     * Cache filename.
     */
    'cache_version_file_name' => 'storyblok-content-version.json',

    /**
     * Cache location on the selected disk
     */
    'cache_path' => 'storyblok/cache',

    /**
     * Storage disk
     */
    'disk' => 'local',

    /**
     * Enable edit mode.
     */
    'enable_edit_mode' => env('STORYBLOK_ENABLE_EDIT_MODE', false),
];
```

## Usage

## The base class

This package provides a wrapper around the default Storyblok client class and registers it within the Laravel service container.

```php
<?php

use TakeTheLead\LaravelStoryblok\Storyblok;

class SomeClass
{
    private TakeTheLead\LaravelStoryblok\Storyblok $storyblok;

    public function __construct(Storyblok $storyblok)
    {
        $this->storyblok = $storyblok;
    }
    
    public function someMethod()
    {
        $this->storyblok->getStoryBySlug("story-slug");
        $this->storyblok->getStoryByUuid("story-uuid");
    }
}
```

## The ClearStoryblokCacheCommand

This package provides a way to specify content cache versions to Storyblok, you can clear the current cache version by executing the below artisan command.

> Note: it is recommended to have a workflow for handling deployments & content changes from within Storyblok.
> This can be done by adding the command to your deploy script and by configureting a webhook in Storyblok to listen for content changes.

```bash
php artisan storyblok:clear-cache
``` 

## Richtext resolver

The package automatically requires and installs the Storyblok richtecht resolver package for php to parse storry content formats.
More information can be found in the [official package](https://github.com/storyblok/storyblok-php-richtext-renderer).

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
