<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        ...$roles
    ): Response {

        $role = session('admin_role');

        if (!$role) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (!in_array($role, $roles)) {

            abort(
                403,
                'Anda tidak memiliki hak akses untuk halaman ini.'
            );
        }

        return $next($request);
    }
}
