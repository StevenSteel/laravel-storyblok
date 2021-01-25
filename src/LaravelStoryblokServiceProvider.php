<?php

namespace TakeTheLead\LaravelStoryblok;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Storyblok\Client;
use Storyblok\RichtextRender\Resolver;
use TakeTheLead\LaravelStoryblok\Commands\ClearStoryblokCacheCommand;
use TakeTheLead\LaravelStoryblok\Http\Controllers\StoryblokWebhookController;

class LaravelStoryblokServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-storyblok.php' => config_path('laravel-storyblok.php'),
            ], 'config');

            $this->commands([
                ClearStoryblokCacheCommand::class,
            ]);
        }

        $this->registerRouteMacros();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-storyblok.php', 'laravel-storyblok');

        $this->app->singleton(Client::class, function () {
            $client = new Client(config('laravel-storyblok.api_key'));
            $client->editMode(config('laravel-storyblok.enable_edit_mode', false));

            if (config('laravel-storyblok.enable_local_cache')) {
                $client->setCache('filesystem', [
                    'path' => Storage::disk(config('laravel-storyblok.disk'))
                        ->path(config('laravel-storyblok.cache_path')),
                ]);

                $client->cacheVersion = $this->getStoryblokCacheVersion();
            }

            return $client;
        });

        $this->app->singleton(Resolver::class, function () {
            return new Resolver();
        });

        $this->app->alias(Storyblok::class, 'storyblok');
    }

    private function getStoryblokCacheVersion()
    {
        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');

        if (! Storage::disk(config('laravel-storyblok.disk'))->exists("$versionFilePath/$versionFileName")) {
            Storage::disk(config('laravel-storyblok.disk'))
                ->put("$versionFilePath/$versionFileName", json_encode(['version' => time()]));

            return $this->getStoryblokCacheVersion();
        }

        $versionData = Storage::disk(config('laravel-storyblok.disk'))->get("$versionFilePath/$versionFileName");
        $versionData = json_decode($versionData);

        return $versionData->version ?? time();
    }

    private function registerRouteMacros()
    {
        Route::macro('storyblok', function () {
            Route::group(['middleware' => config('laravel-storyblok.route_middleware')], function () {
                Route::post('storyblok/webhook', StoryblokWebhookController::class);
            });
        });
    }
}
