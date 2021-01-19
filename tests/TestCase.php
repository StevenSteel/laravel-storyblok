<?php

namespace TakeTheLead\LaravelStoryblok\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use TakeTheLead\LaravelStoryblok\LaravelStoryblokServiceProvider;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelStoryblokServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
    }
}
