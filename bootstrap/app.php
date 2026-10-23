<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
        $middleware->redirectGuestsTo('/login');
        $middleware->alias([
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->report(function (Throwable $e) {
            error_log("Error Backend : {$e->getMessage()}" . " in ", $e->getLine());
        });

        $exceptions->render(function (
            HttpExceptionInterface $exception,
            Request                $request,
        ) {
            // Preserve API and JSON responses.
            if ($request->is('api/*') || $request->expectsJson()) {
                return null;
            }

            // Preserve the original response for signature image requests.
            if ($request->is('signatures/*/image')) {
                return null;
            }

            $status = $exception->getStatusCode();

            if (!in_array($status, [
                403,
                404,
                405,
                419,
                500,
                503,
            ], true)) {
                return null;
            }

            logger()->info('404 Authentication Debug', [
                'path' => $request->path(),
                'is_authenticated' => Auth::check(),
                'user_id' => Auth::id(),
                'session_id' => $request->hasSession()
                    ? $request->session()->getId()
                    : null,
            ]);

            $sharedProps = [];
            try {
                $sharedProps = (new HandleInertiaRequests())->share($request);
            } catch (\Throwable $e) {
                // Fallback if shared props cannot be resolved
            }

            return inertia('ErrorPage', array_merge($sharedProps, [
                'status' => $status,
                'auth' => [
                    'user' => Auth::user(),
                ],
            ]))->toResponse($request)->setStatusCode($status);
        });


        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
