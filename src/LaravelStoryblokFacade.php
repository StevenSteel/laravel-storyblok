<?php

namespace TakeTheLead\LaravelStoryblok;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TakeTheLead\LaravelStoryblok\LaravelStoryblok
 */
class LaravelStoryblokFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-storyblok';
    }
}
