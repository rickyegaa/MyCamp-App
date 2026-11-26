<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! $request->user()) {
            return redirect()->route('login');
        }

        $userRole = strtolower($request->user()->role->nama_role ?? '');
        $allowedRoles = array_map('strtolower', $roles);

        if (! in_array($userRole, $allowedRoles, true)) {
            abort(403, 'Akses ditolak. Peran Anda tidak memiliki izin untuk membuka halaman ini.');
        }

        return $next($request);
    }
}