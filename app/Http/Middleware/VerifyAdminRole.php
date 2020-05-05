<?php

namespace App\Http\Middleware;

use App\Exceptions\AdminForbiddenException;
use Closure;
use Illuminate\Http\Request;
use Throwable;

class VerifyAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Throwable
     */
    public function handle($request, Closure $next)
    {
        throw_if(!auth()->user()->isAdmin(), new AdminForbiddenException('Forbidden Error: You must be administrator', 403));

        return $next($request);
    }
}
