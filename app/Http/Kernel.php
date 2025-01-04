<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance::class, // Handles maintenance mode
        \Illuminate\Http\Middleware\HandleCors::class, // Handles Cross-Origin Resource Sharing (CORS)
        \App\Http\Middleware\TrustProxies::class, // Handles proxy headers for secure connections
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, // Validates maximum POST size
        \App\Http\Middleware\TrimStrings::class, // Trims request input strings
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, // Converts empty strings to null
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api', // Limits API request rates
            \Illuminate\Routing\Middleware\SubstituteBindings::class, // Resolves route model bindings
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class, // Handles authentication
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, // Handles request throttling
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Verifies email addresses
        'auth:sanctum' => \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Sanctum auth
    ];
}
