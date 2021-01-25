<?php

namespace TakeTheLead\LaravelStoryblok\Commands;

use Illuminate\Console\Command;
use TakeTheLead\LaravelStoryblok\Actions\ClearCacheAction;

class ClearStoryblokCacheCommand extends Command
{
    public $signature = 'storyblok:clear-cache';

    public $description = 'Clear the local Storyblok cache';

    public function handle(ClearCacheAction $clearCacheAction)
    {
        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');

        $clearCacheAction->execute();

        $this->info("New cache version saved in $versionFilePath/$versionFileName");
    }
}
