<?php

namespace App\Http\Controllers\Admin\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\StoreRequest;
use App\Http\Requests\Api\V1\User\UpdateRequest;
use App\Http\Resources\V1\User as UserResource;
use App\Http\Resources\V1\UserCollection;
use App\Http\Responses\V1\DeleteResponse;
use App\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     */
    public function index()
    {
        return new UserCollection(User::query()
            ->leftJoin('timesheet_statistics', function (JoinClause $join) {
                $join->on('users.id', '=', 'timesheet_statistics.user_id')
                    ->where('month', now()->format('Y-m'));
            })
            ->select([
                DB::raw('users.*'),
                'month',
                'submit_times',
                'late_submit_times',
            ])
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
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->storePublicly('avatars', 'public');
        }

        return new UserResource(User::create($data));
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource
     */
    public function show(User $user)
    {
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
        return new UserResource($user->updateByRequest($request)->load('leader'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return DeleteResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return new DeleteResponse(__('messages.users.deleted'));
    }
}
