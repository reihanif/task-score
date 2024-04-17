<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $allowAccess = false;

        if ($request->user()->role == 'superadmin') {
            $allowAccess = true;
        }

        if ($permission == 'manage_user' && $request->user()->permission->manage_user) {
            $allowAccess = true;
        }

        if ($permission == 'manage_department' && $request->user()->permission->manage_department) {
            $allowAccess = true;
        }

        if ($permission == 'manage_position' && $request->user()->permission->manage_position) {
            $allowAccess = true;
        }

        if (!$allowAccess) {
            return redirect()->back()->withErrors('You don\'t have permission for the page');
        }

        return $next($request);
    }
}
