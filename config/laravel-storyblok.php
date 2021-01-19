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
];
