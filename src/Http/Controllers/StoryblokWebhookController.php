<?php

namespace TakeTheLead\LaravelStoryblok\Http\Controllers;

use Illuminate\Http\Response;
use TakeTheLead\LaravelStoryblok\Actions\ActionInterface;

class StoryblokWebhookController
{
    public function __invoke()
    {
        collect(config('laravel-storyblok.webhook_actions', []))
            ->filter(function ($action) {
                return app($action) instanceof ActionInterface;
            })
            ->each(function ($action) {
                app($action)->execute();
            });

        return response('', Response::HTTP_OK);
    }
}
