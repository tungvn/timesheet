<?php

namespace App\Http\Controllers\Api\V1\Me;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Me\UpdateRequest;
use App\Http\Resources\V1\User as UserResource;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;

class MeController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show()
    {
        $this->authorize('me', User::class);

        return new UserResource(auth()->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @return UserResource
     */
    public function update(UpdateRequest $request)
    {
        return new UserResource(auth()->user()->updateByRequest($request));
    }
}
