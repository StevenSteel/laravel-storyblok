<?php

namespace TakeTheLead\LaravelStoryblok;

use Exception;
use Storyblok\Client;

class Storyblok
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getStoryBySlug(string $slug): array
    {
        $response = $this->client->getStoryBySlug($slug);

        if (! $response->getBody() && ! isset($response->getBody()['story'])) {
            throw new Exception('Invalid Storyblok api call');
        }

        return $response->getBody()['story'];
    }

    public function getStoryByUuid(string $uuid): array
    {
        $response = $this->client->getStoryByUuid($uuid);

        if (! $response->getBody() && ! isset($response->getBody()['story'])) {
            throw new Exception('Invalid Storyblok api call');
        }

        return $response->getBody()['story'];
    }

    public function getApi(): Client
    {
        return $this->client;
    }
}
