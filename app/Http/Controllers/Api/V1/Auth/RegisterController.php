<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegistrationRequest;
use App\User;

class RegisterController extends Controller
{
    /**
     * Register new user
     *
     * @param \App\Http\Requests\Api\V1\Auth\RegistrationRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegistrationRequest $request)
    {
        User::create($request->only([
            'username',
            'email',
            'password',
        ]));

        return response([
            'data' => [
                'message' => trans('auth.register'),
            ],
        ], 200);
    }
}
