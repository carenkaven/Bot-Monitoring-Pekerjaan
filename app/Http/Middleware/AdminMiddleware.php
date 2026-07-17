<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Hanya izinkan user dengan role "admin" mengakses route ini.
     * Karyawan (atau tamu yang lolos ke sini) akan ditolak.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki akses ke halaman Administrator.');
        }

        return $next($request);
    }
}
