<?php

namespace TakeTheLead\LaravelStoryblok\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Storyblok\Client;

class ClearStoryblokCacheCommand extends Command
{
    public $signature = 'storyblok:clear-cache';

    public $description = 'Clear the local Storyblok cache';

    public function handle(Client $storyblokClient)
    {
        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');
        $versionData = json_encode(['version' => time()]);

        Storage::disk(config('laravel-storyblok.disk'))->put("$versionFilePath/$versionFileName", $versionData);

        $storyblokClient->flushCache();

        $this->info("New version saved in $versionFilePath/$versionFileName");
    }
}
