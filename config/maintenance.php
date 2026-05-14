<?php

$csvToArray = static function (string $value): array {
    return array_values(array_filter(array_map('trim', explode(',', $value))));
};

$blockedUrisFromEnv = env('MAINTENANCE_BLOCKED_URIS');
$blockedRouteNamesFromEnv = env('MAINTENANCE_BLOCKED_ROUTE_NAMES');
$exceptUrisFromEnv = env('MAINTENANCE_EXCEPT_URIS');

return [
    /*
    |--------------------------------------------------------------------------
    | Maintenance Toggle
    |--------------------------------------------------------------------------
    |
    | Set to true to enable maintenance restrictions.
    |
    */
    'enabled' => env('MAINTENANCE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Block All Web URIs
    |--------------------------------------------------------------------------
    |
    | When true, all web routes are blocked except those listed in except_uris.
    |
    */
    'block_all' => env('MAINTENANCE_BLOCK_ALL', false),

    /*
    |--------------------------------------------------------------------------
    | Block Specific URI Patterns
    |--------------------------------------------------------------------------
    |
    | Supports wildcards. Examples: admin/*, students/*, profile1
    |
    */
    'blocked_uris' => is_string($blockedUrisFromEnv)
        ? $csvToArray($blockedUrisFromEnv)
        : [
            // 'administrator/*',
            // 'students/*',
        ],

    /*
    |--------------------------------------------------------------------------
    | Block Specific Route Name Patterns
    |--------------------------------------------------------------------------
    |
    | Supports wildcards. Examples: students.*, dashboard
    |
    */
    'blocked_route_names' => is_string($blockedRouteNamesFromEnv)
        ? $csvToArray($blockedRouteNamesFromEnv)
        : [
            // 'students.*',
            // 'dashboard',
        ],

    /*
    |--------------------------------------------------------------------------
    | Always Allowed URI Patterns
    |--------------------------------------------------------------------------
    |
    | These URIs are always allowed while maintenance is enabled.
    |
    */
    'except_uris' => is_string($exceptUrisFromEnv)
        ? $csvToArray($exceptUrisFromEnv)
        : [
            'up',
        ],
];
