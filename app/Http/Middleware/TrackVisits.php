<?php

namespace App\Http\Middleware;

use App\Models\VisitLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class TrackVisits
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->getStatusCode() < 200 || $response->getStatusCode() >= 300) {
            return $response;
        }

        try {
            $this->record($request);
        } catch (\Throwable $e) {
            Log::warning('Visit tracking failed: '.$e->getMessage());
        }

        return $response;
    }

    protected function record(Request $request): void
    {
        if (! $request->isMethod('GET')) {
            return;
        }

        // Never track the admin panel itself.
        if ($request->is('admin') || $request->is('admin/*')) {
            return;
        }

        // Skip AJAX/asset/API noise and obvious bots.
        if ($request->ajax() || $request->expectsJson() || $request->is('build/*')) {
            return;
        }

        $userAgent = (string) $request->userAgent();

        if ($this->isBot($userAgent)) {
            return;
        }

        VisitLog::create([
            'url' => $request->path(),
            'ip_hash' => $this->hashIp($request->ip()),
            'device' => $this->device($userAgent),
            'user_agent' => strlen($userAgent) > 500 ? substr($userAgent, 0, 500) : $userAgent,
            'referer' => $request->headers->get('referer'),
            'visited_at' => now(),
        ]);
    }

    protected function hashIp(?string $ip): string
    {
        return hash('sha256', ($ip ?: 'unknown').'|'.config('app.key'));
    }

    protected function device(string $userAgent): string
    {
        if (preg_match('/iPad|Tablet|PlayBook|Silk/i', $userAgent)) {
            return 'tablet';
        }

        if (preg_match('/Mobile|iPhone|Android|Windows Phone/i', $userAgent)) {
            return 'mobile';
        }

        return 'desktop';
    }

    protected function isBot(string $userAgent): bool
    {
        if ($userAgent === '') {
            return true;
        }

        return (bool) preg_match('/bot|crawler|spider|slurp|curl|wget|postman|headless|python|facebookexternalhit|GoogleOther|bingpreview/i', $userAgent);
    }
}