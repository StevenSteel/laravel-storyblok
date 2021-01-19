<?php

namespace TakeTheLead\LaravelStoryblok\Tests;

use Illuminate\Support\Facades\Storage;
use Storyblok\Client;
use TakeTheLead\LaravelStoryblok\Storyblok;

class StoryblokTest extends TestCase
{
    /** @test */
    public function it_can_use_the_api_without_specifing_a_cache_version()
    {
        $storyblokClient = app(Client::class);

        $this->assertNull($storyblokClient->cacheVersion);
    }

    /** @test */
    public function it_can_use_the_api_with_a_cache_version()
    {
        config()->set('laravel-storyblok.enable_local_cache', true);

        $storyblokClient = app(Client::class);

        $this->assertNotNull($storyblokClient->cacheVersion);
    }

    /** @test */
    public function when_the_cache_is_enabled_it_generates_a_new_version_when_no_previous_version_exists()
    {
        $versionFileName = config('laravel-storyblok.cache_version_file_name');
        $versionFilePath = config('laravel-storyblok.cache_path');
        $expectedVersionLocation = "$versionFilePath/$versionFileName";

        config()->set('laravel-storyblok.enable_local_cache', true);

        Storage::fake();

        Storage::assertMissing($expectedVersionLocation);

        app(Storyblok::class);

        Storage::assertExists($expectedVersionLocation);

        $versionFileContents = Storage::disk(config('laravel-storyblok.disk'))->get($expectedVersionLocation);
        $versionData = json_decode($versionFileContents);

        $this->assertJson($versionFileContents);
        $this->assertTrue(isset($versionData->version));
        $this->assertNotEmpty($versionData->version);
    }
}
