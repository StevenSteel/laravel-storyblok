<?php

namespace TakeTheLead\LaravelStoryblok;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Storyblok\Client;
use Storyblok\RichtextRender\Resolver;
use TakeTheLead\LaravelStoryblok\Commands\ClearStoryblokCacheCommand;

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
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-storyblok.php', 'laravel-storyblok');

        $this->app->singleton(Client::class, function ($app) {
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
}
