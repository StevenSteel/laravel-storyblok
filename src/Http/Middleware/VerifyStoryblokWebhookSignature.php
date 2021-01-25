<?php

namespace TakeTheLead\LaravelStoryblok\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class VerifyStoryblokWebhookSignature
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('webhook-signature') && ! empty($request->header('webhook-signature'))) {
            $signature = hash_hmac('sha1', $request->getContent(), config('laravel-storyblok.webhook_secret'));

            if ($signature !== $request->header('webhook-signature')) {
                abort(403);
            }
        }

        return $next($request);
    }
}
