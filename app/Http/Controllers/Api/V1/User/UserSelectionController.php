<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\User\SelectionInputRequest;
use App\Http\Resources\V1\UserSelectionCollection;
use App\User;
use Illuminate\Database\Eloquent\Builder;

class UserSelectionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param SelectionInputRequest $request
     * @return UserSelectionCollection
     */
    public function __invoke(SelectionInputRequest $request)
    {
        $builder = User::query();
        if (!is_null($excludedId = $request->input('excluded'))) {
            $builder = $builder->whereKeyNot($excludedId);
        }

        if (!is_null($s = $request->input('s'))) {
            $builder = $builder->where(function (Builder $query) use ($s) {
                $query->where('username', 'like', "%$s%")
                    ->orWhere('email', 'like', "%$s%");
            });
        }

        return new UserSelectionCollection($builder->limit(20)->get([
            'username as label',
            'id as value',
        ]));
    }
}
