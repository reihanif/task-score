<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $allowAccess = false;

        if ($request->user()->id == $request->route('user')) {
            $allowAccess = true;
        }

        if ($request->user()->role == $role) {
            $allowAccess = true;
        }

        if (!$allowAccess) {
            return redirect()->route('homepage')->withErrors('You don\'t have permission for the page');
        }

        return $next($request);
    }
}
