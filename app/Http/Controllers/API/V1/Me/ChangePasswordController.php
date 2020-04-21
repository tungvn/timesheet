<?php

namespace App\Http\Controllers\API\V1\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Me\ChangePasswordRequest;
use App\Http\Responses\V1\SuccessfulMessageResponse;
use Illuminate\Http\Request;

class ChangePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \App\Http\Requests\Api\V1\Me\ChangePasswordRequest $request
     * @return \App\Http\Responses\V1\SuccessfulMessageResponse
     */
    public function __invoke(ChangePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => $request->input('new_password'),
        ]);

        return new SuccessfulMessageResponse(__('messages.user.password-changed'));
    }
}
