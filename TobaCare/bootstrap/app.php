<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
   ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
})
->withExceptions(function (Exceptions $exceptions) {
    $exceptions->render(function (\App\Exceptions\ApiException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => array_merge([
                    'code'    => $e->errorCode,
                    'message' => $e->getMessage(),
                ], $e->extra),
            ], $e->statusCode);
        }
    });

    $exceptions->render(function (ValidationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'VALIDATION_ERROR',
                    'message' => 'Data tidak valid',
                    'fields'  => collect($e->errors())->map(fn ($m) => $m[0]),
                ],
            ], 422);
        }
    });

    $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'UNAUTHENTICATED',
                    'message' => 'Unauthenticated.',
                ],
            ], 401);
        }
    });

    $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'FORBIDDEN',
                    'message' => $e->getMessage() ?: 'Anda tidak memiliki akses',
                ],
            ], 403);
        }
    });

    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'FORBIDDEN',
                    'message' => $e->getMessage() ?: 'Anda tidak memiliki akses',
                ],
            ], 403);
        }
    });

    $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'NOT_FOUND',
                    'message' => 'Data tidak ditemukan',
                ],
            ], 404);
        }
    });

    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'NOT_FOUND',
                    'message' => 'Data tidak ditemukan',
                ],
            ], 404);
        }
    });

    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'TOO_MANY_REQUESTS',
                    'message' => 'Terlalu banyak permintaan',
                ],
            ], 429);
        }
    });

    $exceptions->render(function (\Illuminate\Http\Exceptions\ThrottleRequestsException $e, Request $request) {
        if ($request->is('api/*')) {
            return response()->json([
                'error' => [
                    'code'    => 'TOO_MANY_REQUESTS',
                    'message' => 'Terlalu banyak permintaan',
                ],
            ], 429);
        }
    });

    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, Request $request) {
        if ($request->is('api/*')) {
            $status = $e->getStatusCode();
            if ($status === 403) {
                return response()->json([
                    'error' => [
                        'code'    => 'FORBIDDEN',
                        'message' => $e->getMessage() ?: 'Anda tidak memiliki akses',
                    ],
                ], 403);
            }
            if ($status === 404) {
                return response()->json([
                    'error' => [
                        'code'    => 'NOT_FOUND',
                        'message' => 'Data tidak ditemukan',
                    ],
                ], 404);
            }
            if ($status === 429) {
                return response()->json([
                    'error' => [
                        'code'    => 'TOO_MANY_REQUESTS',
                        'message' => 'Terlalu banyak permintaan',
                    ],
                ], 429);
            }
        }
    });
})->create();