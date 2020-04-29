<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogoutController extends Controller
{
    /**
     * Log a user out.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        /** @var \Laravel\Passport\Token $accessToken */
        $accessToken = $request->user('api')->token();

        DB::table('oauth_refresh_tokens')->whereAccessTokenId($accessToken->id)
            ->update(['revoked' => true]);

        $accessToken->revoke();

        return response()
            ->json([
                'data' => [
                    'message' => trans('auth.logout'),
                ],
            ])
            ->cookie(config('auth.cookie.auth'), 'logged-out', 1, '/', $request->getHost())
            ->cookie(config('auth.cookie.refresh'), 'logged-out', 1, '/', $request->getHost())
            ->cookie(config('auth.cookie.loggedIn'), false, 1, '/', $request->getHost(), false, false);
    }
}
