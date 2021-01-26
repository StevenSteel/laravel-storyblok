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
<?php

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

    /**
     * The webhook secret, you can leave this empty when you are not using a secret.
     */
    'webhook_secret' => env('STORYBLOK_WEBHOOK_SECRET', ''),

    /**
     * The middleware that should be applied to the webhook route.
     */
    'route_middleware' => [
        \TakeTheLead\LaravelStoryblok\Http\Middleware\VerifyStoryblokWebhookSignature::class,
    ],

    /**
     * The actions that should be execute whenever the webhook gets called.
     *
     * All actions should implement the \TakeTheLead\LaravelStoryblok\Actions\ActionInterface
     */
    'webhook_actions' => [
        \TakeTheLead\LaravelStoryblok\Actions\ClearCacheAction::class,
    ],
];
```

## Usage

## The base class

This package provides a wrapper around the default Storyblok client class and registers it within the Laravel service container.

```php
use Storyblok;

Storyblok::getStoryBySlug("story-slug");
Stroyblok::getStoryByUuid("story-uuid");
```

## Need something else?
If you need more functionality you get an instance of the underlying Storyblok API with:

```php
use Storyblok;

$api = Storyblok::getApi();
```

## Handling webhooks
This package ships with a preconfigured setup for handling webhooks. Simply add the route below to your routes file.

```php
Route::storyblok();
```

> Make sure to add this route to the `except` array within the `VerifyCsrfToken` middleware to prevent token mismatches.

### Verifing the webhook signature
If you have configured a webhook secret in Storyblok, make sure to add it as an environment variable to your env file.
Out of the box a middleware is applied to your route to verify the signature. You are however free to add your own implementation (or add extra middleware) from within `route_middleware` setting in the config file.

```
STORYBLOK_WEBHOOK_SECRET=your-secret
```

### Performing actions whenever the webhook is called
Within the config file you can specify which actions should be performed whenever the webhook is being called. The setting key is called `webhook_actions`.
When adding your own action classes, make sure they implement the `\TakeTheLead\LaravelStoryblok\Actions\ActionInterface`. Otheriwse your action won't be exectued.

Example:
```
<?php

use \TakeTheLead\LaravelStoryblok\Actions\ActionInterface;

class YourAction implements ActionInterface
{
    public function __construct()
    {
        // you can inject any class registerd within the IOC container
    }

    public function execute(): void
    {
        // Perform your action
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

- [Joren Van Hocht](https://github.com/jorenvh)
- [Take The Lead](https://takethelead.be)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
