<?php

namespace App\Http\Controllers\API\V1\Auth;

use Laravel\Passport\Http\Controllers\AccessTokenController as PassportAccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AccessTokenController extends PassportAccessTokenController
{
    /**
     * Authorize a client to access the user's account.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
    {
        $response = parent::issueToken($request);

        $responseContent = collect(json_decode($response->getContent(), true));
        $token = sprintf('%s %s', $responseContent->get('token_type'), $responseContent->get('access_token'));
        $refreshToken = $responseContent->get('refresh_token');

        $tokenTimeout = config('auth.timeout.token') * 60;
        $refreshTokenTimeout = config('auth.timeout.refresh_token') * 60;

        return $response->cookie(config('auth.cookie.auth'), $token, $tokenTimeout, '/', $request->getUri()
                                                                                                 ->getHost())
                        ->cookie(config('auth.cookie.refresh'), $refreshToken, $refreshTokenTimeout, '/', $request->getUri()
                                                                                                                  ->getHost())
                        ->cookie(config('auth.cookie.loggedIn'), true, $refreshTokenTimeout, '/', $request->getUri()
                                                                                                          ->getHost(), false, false);
    }
}
