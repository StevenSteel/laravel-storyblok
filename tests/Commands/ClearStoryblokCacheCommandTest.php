<?php

namespace TakeTheLead\LaravelStoryblok\Tests\Commands;

use Illuminate\Support\Facades\Storage;
use TakeTheLead\LaravelStoryblok\Commands\ClearStoryblokCacheCommand;
use TakeTheLead\LaravelStoryblok\Tests\TestCase;

class ClearStoryblokCacheCommandTest extends TestCase
{
    /** @test */
    public function it_can_clear_the_storyblok_cahce()
    {
        Storage::fake();

        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');
        $expectedVersionLocation = "$versionFilePath/$versionFileName";
        $originalVersion = time() - 1;

        Storage::put($expectedVersionLocation, json_encode(['version' => $originalVersion]));

        $this->artisan(ClearStoryblokCacheCommand::class)
            ->expectsOutput("New cache version saved in $expectedVersionLocation");

        Storage::disk(config('laravel-storyblok.disk'))
            ->assertExists($expectedVersionLocation);

        $versionFileContents = Storage::disk(config('laravel-storyblok.disk'))->get($expectedVersionLocation);

        $this->assertJson($versionFileContents);

        $versionData = json_decode($versionFileContents);

        $this->assertTrue(isset($versionData->version));
        $this->assertNotEmpty($versionData->version);
        $this->assertNotSame($versionData->version, $originalVersion);
    }
}
