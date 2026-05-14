<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // --- LOGIKA SATPAM MULTI-ROLE: Nendang yang belum login ---
        $middleware->redirectGuestsTo(function (Request $request) {

            // Kalau dia nyoba masuk lorong guru tapi belum login, tendang ke login guru
            if ($request->is('dashboard-guru*')) {
                return route('login.guru');
            }

            // Kalau dia nyoba masuk lorong siswa tapi belum login, tendang ke login siswa
            if ($request->is('dashboard-siswa*')) {
                return route('login.siswa');
            }

            // Sisanya (termasuk kalau nyoba masuk lorong admin), tendang ke login admin
            return route('login.admin');
        });

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
