<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\V1\User as UserResource;
use App\Http\Resources\V1\UserCollection;
use App\Http\Responses\V1\DeleteResponse;
use App\Http\Responses\V1\SuccessfulMessageResponse;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Http\Resources\V1\UserCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', User::class);

        $page = max(1, intval($request->input('page', 1)));

        return new UserCollection(User::query()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Api\V1\User\StoreRequest $request
     * @return \App\Http\Resources\V1\User
     */
    public function store(StoreRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \App\Http\Resources\V1\User
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Api\V1\User\UpdateRequest $request
     * @param \App\User                                    $user
     * @return \App\Http\Resources\V1\User
     */
    public function update(UpdateRequest $request, User $user)
    {
        return new UserResource(tap($user)->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \App\Http\Responses\V1\DeleteResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return new DeleteResponse(__('messages.users.deleted'));
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param \App\User $user
     * @return \App\Http\Responses\V1\SuccessfulMessageResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function restore(User $user)
    {
        $this->authorize('restore', $user);

        $user->restore();

        return new SuccessfulMessageResponse(__('messages.users.restored'));
    }
}
