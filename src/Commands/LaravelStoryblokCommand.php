<?php

namespace TakeTheLead\LaravelStoryblok\Commands;

use Illuminate\Console\Command;

class LaravelStoryblokCommand extends Command
{
    public $signature = 'laravel-storyblok';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
