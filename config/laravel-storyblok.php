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
