<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiCookieAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->setBearerToken($request);

        $this->setRefreshTokenIfExists($request);

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function setBearerToken(Request &$request)
    {
        $grantType = $request->input('grant_type');
        $authCookie = $request->cookie(config('auth.cookie.auth'));
        if (empty($grantType) && !empty($authCookie)) {
            $request->headers->set('Authorization', $authCookie);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     */
    private function setRefreshTokenIfExists(Request &$request)
    {
        $grantType = $request->input('grant_type');
        $refreshCookie = $request->cookie(config('auth.cookie.refresh'));
        if ($grantType === 'refresh_token' && !empty($refreshCookie)) {
            $request->request->set('refresh_token', $refreshCookie);
        }
    }
}
