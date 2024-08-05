<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Involved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $allowAccess = false;

        if ($request->user()->isTaskmaster($request->route('assignment'))) {
            $allowAccess = true;
        }

        if ($request->user()->isTaskAssignee($request->task)) {
            $allowAccess = true;
        }

        if (!$allowAccess) {
            abort(404);
        }

        return $next($request);
    }
}
