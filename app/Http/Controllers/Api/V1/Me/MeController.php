<?php

namespace App\Http\Controllers\Api\V1\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Me\UpdateRequest;
use App\Http\Resources\V1\User as UserResource;
use App\User;

class MeController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \App\Http\Resources\V1\User
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show()
    {
        $this->authorize('me', User::class);

        return new UserResource(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Api\V1\Me\UpdateRequest $request
     * @return \App\Http\Resources\V1\User
     */
    public function update(UpdateRequest $request)
    {
        $user = auth()->user();

        return new UserResource(tap($user)->update($request->only($user->getFillable())));
    }
}
