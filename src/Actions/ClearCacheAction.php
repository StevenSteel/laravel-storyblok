<?php

namespace TakeTheLead\LaravelStoryblok\Actions;

use Illuminate\Support\Facades\Storage;
use Storyblok\Client;

class ClearCacheAction implements ActionInterface
{
    /**
     * @var \Storyblok\Client
     */
    private Client $storyblokClient;

    public function __construct(Client $storyblokClient)
    {
        $this->storyblokClient = $storyblokClient;
    }

    public function execute(): void
    {
        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');
        $versionData = json_encode(['version' => time()]);

        Storage::disk(config('laravel-storyblok.disk'))->put("$versionFilePath/$versionFileName", $versionData);

        $this->storyblokClient->flushCache();
    }
}
