<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceBlocker
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('maintenance-manager*') || $request->routeIs('maintenance-manager.*')) {
            return $next($request);
        }

        $settings = $this->resolveSettings();

        if (! ($settings['enabled'] ?? false)) {
            return $next($request);
        }

        $exceptUris = $settings['except_uris'] ?? [];
        if ($this->matchesAnyUriPattern($request, $exceptUris)) {
            return $next($request);
        }

        if (($settings['block_all'] ?? false) === true) {
            return $this->maintenanceResponse();
        }

        $blockedUris = $settings['blocked_uris'] ?? [];
        if ($this->matchesAnyUriPattern($request, $blockedUris)) {
            return $this->maintenanceResponse();
        }

        $blockedRouteNames = $settings['blocked_route_names'] ?? [];
        if ($this->matchesAnyRouteName($request, $blockedRouteNames)) {
            return $this->maintenanceResponse();
        }

        return $next($request);
    }

    /**
     * Match request URI against wildcard patterns like admin/*.
     */
    protected function matchesAnyUriPattern(Request $request, array $patterns): bool
    {
        $path = trim($request->path(), '/');
        $path = $path === '' ? '/' : $path;

        foreach ($patterns as $pattern) {
            if (! is_string($pattern)) {
                continue;
            }

            $normalizedPattern = trim($pattern);
            if ($normalizedPattern === '') {
                continue;
            }

            if ($normalizedPattern === '/' && $path === '/') {
                return true;
            }

            $normalizedPattern = ltrim($normalizedPattern, '/');

            if ($request->is($normalizedPattern)) {
                return true;
            }

            if ($path === $normalizedPattern) {
                return true;
            }
        }

        return false;
    }

    /**
     * Match current route name against wildcard patterns.
     */
    protected function matchesAnyRouteName(Request $request, array $routeNamePatterns): bool
    {
        foreach ($routeNamePatterns as $pattern) {
            if (is_string($pattern) && $request->routeIs($pattern)) {
                return true;
            }
        }

        return false;
    }

    protected function maintenanceResponse(): Response
    {
        if (View::exists('maintenance')) {
            return response()->view('maintenance', [], 503);
        }

        abort(503, 'This page is under maintenance.');
    }

    /**
     * Resolve maintenance settings from storage override and config defaults.
     */
    protected function resolveSettings(): array
    {
        $defaults = [
            'enabled' => (bool) config('maintenance.enabled', false),
            'block_all' => (bool) config('maintenance.block_all', false),
            'blocked_uris' => $this->normalizeArray(config('maintenance.blocked_uris', [])),
            'blocked_route_names' => $this->normalizeArray(config('maintenance.blocked_route_names', [])),
            'except_uris' => $this->normalizeArray(config('maintenance.except_uris', ['up'])),
        ];

        $path = storage_path('app/maintenance-settings.json');
        if (! is_file($path)) {
            return $defaults;
        }

        $raw = file_get_contents($path);
        $decoded = json_decode($raw ?: '[]', true);
        if (! is_array($decoded)) {
            return $defaults;
        }

        return [
            'enabled' => (bool) ($decoded['enabled'] ?? $defaults['enabled']),
            'block_all' => (bool) ($decoded['block_all'] ?? $defaults['block_all']),
            'blocked_uris' => $this->normalizeArray($decoded['blocked_uris'] ?? $defaults['blocked_uris']),
            'blocked_route_names' => $this->normalizeArray($decoded['blocked_route_names'] ?? $defaults['blocked_route_names']),
            'except_uris' => $this->normalizeArray($decoded['except_uris'] ?? $defaults['except_uris']),
        ];
    }

    protected function normalizeArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        $normalized = [];
        foreach ($value as $item) {
            if (is_string($item)) {
                $item = trim($item);
                if ($item !== '') {
                    $normalized[] = $item;
                }
            }
        }

        return array_values(array_unique($normalized));
    }
}
