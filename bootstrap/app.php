<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Sanctum: user yang sudah login via browser (session) bisa akses /api/*
        // tanpa token. Akses eksternal tetap via Bearer token.
        $middleware->statefulApi();

        // Daftarkan middleware alias Spatie RBAC untuk Laravel 11+
        $middleware->alias([
            'role'       => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Membedakan "dibuka dari browser" vs "dipanggil aplikasi/klien API".
        // Browser selalu mengirim header Accept berisi text/html, sedangkan
        // Postman/curl/fetch mengirim */* atau application/json.
        $isBrowserApiRequest = fn ($request) => $request->is('api/*')
            && ! $request->bearerToken()
            && ! $request->expectsJson()
            && str_contains((string) $request->header('Accept'), 'text/html');

        // JSON untuk klien API; browser mendapat halaman HTML biasa
        $exceptions->shouldRenderJsonWhen(
            fn ($request, \Throwable $e) => ($request->is('api/*') && ! $isBrowserApiRequest($request))
                || $request->expectsJson()
        );

        // 401 — belum login / token tidak valid
        $exceptions->renderable(function (\Illuminate\Auth\AuthenticationException $e, $request) use ($isBrowserApiRequest) {
            // Browser → ke halaman login; setelah login otomatis kembali ke URL API (redirect()->intended)
            if ($isBrowserApiRequest($request)) {
                return redirect()->guest(route('login'))
                    ->with('status', 'Silakan login terlebih dahulu untuk mengakses data API.');
            }

            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Unauthenticated. Silakan login dan sertakan token Bearer.',
                ], 401);
            }
        });

        // 403 — sudah login tapi role tidak diizinkan
        // (browser → halaman error 403 bawaan Laravel)
        $exceptions->renderable(function (\Spatie\Permission\Exceptions\UnauthorizedException $e, $request) use ($isBrowserApiRequest) {
            if ($request->is('api/*') && ! $isBrowserApiRequest($request)) {
                return response()->json([
                    'message' => 'Akses ditolak. Hanya Administrator dan Petugas Benih yang dapat mengakses data ini.',
                ], 403);
            }
        });

        // Sesi habis / CSRF expired → redirect ke login, bukan tampil 419
        $exceptions->renderable(function (\Illuminate\Session\TokenMismatchException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Sesi telah berakhir, silakan login kembali.'], 419);
            }

            return redirect()->route('login')
                ->with('error', 'Sesi telah berakhir, silakan login kembali.');
        });
    })->create();
