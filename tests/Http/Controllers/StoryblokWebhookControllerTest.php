<?php

namespace TakeTheLead\LaravelStoryblok\Tests\Http\Controllers;

use TakeTheLead\LaravelStoryblok\Actions\ClearCacheAction;
use TakeTheLead\LaravelStoryblok\Tests\Stubs\WebhookActionWithoutInterface;
use TakeTheLead\LaravelStoryblok\Tests\TestCase;

class StoryblokWebhookControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->registerWebhookRoute();
    }

    /** @test */
    public function it_returns_a_2OO_ok_response()
    {
        $this->post('storyblok/webhook', [], ['webhook-signature' => ''])
            ->assertOk();
    }

    /** @test */
    public function it_skips_webhook_actions_that_dont_implement_the_action_interface()
    {
        config()->set('laravel-storyblok.webhook_actions', [
            ClearCacheAction::class,
            WebhookActionWithoutInterface::class,
        ]);

        $this->post('storyblok/webhook', [], ['webhook-signature' => ''])
            ->assertOk();
    }

    /** @test */
    public function it_can_execute_without_actions()
    {
        config()->set('laravel-storyblok.webhook_actions', []);

        $this->post('storyblok/webhook', [], ['webhook-signature' => ''])
            ->assertOk();
    }

    /** @test */
    public function it_does_not_process_request_with_invalid_signatures()
    {
        config()->set('laravel-storyblok.webook_secret', 'TakeTheLeadIsAwesome');

        $this->post('storyblok/webhook', [], ['webhook-signature' => 'abc'])
            ->assertForbidden();
    }

    /** @test */
    public function it_processes_requests_with_valid_signatures()
    {
        config()->set('laravel-storyblok.webhook_secret', 'TakeTheLeadIsAwesome');

        $signature = hash_hmac('sha1', '', 'TakeTheLeadIsAwesome');

        $this->post('storyblok/webhook', [], ['webhook-signature' => $signature])
            ->assertOk();
    }
}
