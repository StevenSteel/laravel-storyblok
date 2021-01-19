<?php

namespace TakeTheLead\LaravelStoryblok;

use Illuminate\Support\ServiceProvider;
use TakeTheLead\LaravelStoryblok\Commands\LaravelStoryblokCommand;

class LaravelStoryblokServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-storyblok.php' => config_path('laravel-storyblok.php'),
            ], 'config');

            $this->commands([
                LaravelStoryblokCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-storyblok.php', 'laravel-storyblok');
    }
}
