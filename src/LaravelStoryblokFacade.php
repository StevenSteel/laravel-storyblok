<?php

namespace TakeTheLead\LaravelStoryblok;

use Illuminate\Support\Facades\Facade;

/**
 * @see \TakeTheLead\LaravelStoryblok\Storyblok
 */
class LaravelStoryblokFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'storyblok';
    }
}
