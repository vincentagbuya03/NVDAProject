<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MaintenanceController extends Controller
{
    private string $settingsPath;

    public function __construct()
    {
        $this->settingsPath = storage_path('app/maintenance-settings.json');
    }

    public function index()
    {
        $settings = $this->readSettings();

        $webUris = collect(Route::getRoutes())
            ->filter(static fn ($route) => in_array('web', $route->middleware(), true))
            ->map(function ($route) {
                $uri = trim($route->uri(), '/');
                $displayUri = $uri === '' ? '/' : '/'.$uri;

                return [
                    'display' => $displayUri,
                    'pattern' => $this->normalizeUriPattern($uri === '' ? '/' : $uri),
                ];
            })
            ->reject(static fn (array $item) => str_starts_with(ltrim($item['pattern'], '/'), '_ignition'))
            ->unique('pattern')
            ->sortBy('display')
            ->values();

        return view('maintenance-manager.index', [
            'settings' => $settings,
            'webUris' => $webUris,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'block_all' => ['nullable', 'boolean'],
            'selected_uris' => ['nullable', 'array'],
            'selected_uris.*' => ['string'],
            'custom_blocked_uris' => ['nullable', 'string'],
            'blocked_route_names' => ['nullable', 'string'],
            'except_uris' => ['nullable', 'string'],
        ]);

        $selectedUris = collect($validated['selected_uris'] ?? [])
            ->map(fn (string $uri) => $this->normalizeUriPattern($uri))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $customBlockedUris = collect($this->parseList($validated['custom_blocked_uris'] ?? ''))
            ->map(fn (string $uri) => $this->normalizeUriPattern($uri))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $blockedUris = array_values(array_unique(array_merge($selectedUris, $customBlockedUris)));

        $settings = [
            'enabled' => (bool) ($validated['enabled'] ?? false),
            'block_all' => (bool) ($validated['block_all'] ?? false),
            'selected_uris' => $selectedUris,
            'custom_blocked_uris' => $customBlockedUris,
            'blocked_uris' => $blockedUris,
            'blocked_route_names' => $this->parseList($validated['blocked_route_names'] ?? ''),
            'except_uris' => $this->parseList($validated['except_uris'] ?? ''),
        ];

        if (! in_array('maintenance-manager*', $settings['except_uris'], true)) {
            $settings['except_uris'][] = 'maintenance-manager*';
        }

        if (! in_array('up', $settings['except_uris'], true)) {
            $settings['except_uris'][] = 'up';
        }

        if (! is_dir(dirname($this->settingsPath))) {
            mkdir(dirname($this->settingsPath), 0755, true);
        }

        file_put_contents($this->settingsPath, json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        $redirect = redirect()
            ->route('maintenance-manager.index')
            ->with('status', 'Maintenance settings saved successfully.');

        if (! $settings['enabled'] && (count($settings['blocked_uris']) > 0 || count($settings['blocked_route_names']) > 0 || $settings['block_all'])) {
            $redirect->with('warning', 'Rules are saved but inactive. Enable maintenance to apply blocking.');
        }

        return $redirect;
    }

    private function readSettings(): array
    {
        $defaults = [
            'enabled' => (bool) config('maintenance.enabled', false),
            'block_all' => (bool) config('maintenance.block_all', false),
            'selected_uris' => array_values(config('maintenance.blocked_uris', [])),
            'custom_blocked_uris' => [],
            'blocked_uris' => array_values(config('maintenance.blocked_uris', [])),
            'blocked_route_names' => array_values(config('maintenance.blocked_route_names', [])),
            'except_uris' => array_values(config('maintenance.except_uris', ['up'])),
        ];

        if (! is_file($this->settingsPath)) {
            return $defaults;
        }

        $raw = file_get_contents($this->settingsPath);
        $decoded = json_decode($raw ?: '[]', true);

        if (! is_array($decoded)) {
            return $defaults;
        }

        return [
            'enabled' => (bool) ($decoded['enabled'] ?? $defaults['enabled']),
            'block_all' => (bool) ($decoded['block_all'] ?? $defaults['block_all']),
            'selected_uris' => $this->normalizeArray($decoded['selected_uris'] ?? $decoded['blocked_uris'] ?? $defaults['selected_uris']),
            'custom_blocked_uris' => $this->normalizeArray($decoded['custom_blocked_uris'] ?? $defaults['custom_blocked_uris']),
            'blocked_uris' => $this->normalizeArray($decoded['blocked_uris'] ?? $defaults['blocked_uris']),
            'blocked_route_names' => $this->normalizeArray($decoded['blocked_route_names'] ?? $defaults['blocked_route_names']),
            'except_uris' => $this->normalizeArray($decoded['except_uris'] ?? $defaults['except_uris']),
        ];
    }

    private function parseList(string $value): array
    {
        return collect(preg_split('/[\r\n,]+/', $value) ?: [])
            ->map(static fn (string $item) => trim($item))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeArray(mixed $value): array
    {
        if (! is_array($value)) {
            return [];
        }

        return collect($value)
            ->map(static fn ($item) => is_string($item) ? trim($item) : '')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeUriPattern(string $value): string
    {
        $value = trim($value);
        if ($value === '' || $value === '/') {
            return '/';
        }

        $value = ltrim($value, '/');
        $value = preg_replace('/\{[^}]+\}/', '*', $value) ?? $value;

        return trim($value);
    }
}
