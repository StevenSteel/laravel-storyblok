<?php

namespace TakeTheLead\LaravelStoryblok\Tests\Stubs;

use Exception;

class WebhookActionWithoutInterface
{
    public function execute()
    {
        throw new Exception('This should not be executed');
    }
}
