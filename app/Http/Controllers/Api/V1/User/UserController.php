<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\V1\User as UserResource;
use App\Http\Resources\V1\UserCollection;
use App\Http\Responses\V1\DeleteResponse;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Query\JoinClause;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', User::class);

        return new UserCollection(User::query()
            ->leftJoin('timesheet_statistics', function (JoinClause $join) {
                $join->on('users.id', '=', 'timesheet_statistics.user_id')
                    ->where('month', now()->format('Y-m'));
            })
            ->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return UserResource
     */
    public function store(StoreRequest $request)
    {
        return new UserResource(User::create($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     * @throws AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateRequest $request, User $user)
    {
        return new UserResource(tap($user)->update($request->all()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return DeleteResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return new DeleteResponse(__('messages.users.deleted'));
    }
}
