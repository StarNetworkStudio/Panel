<?php

namespace App\Http\Middleware;

class CheckAdministrator
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        abort_unless(auth()->user()->isAdmin(), 403, trans('只有管理员才能访问此页面'));

        return $next($request);
    }
}
