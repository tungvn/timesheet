<?php

namespace App\Http\Requests\Api\V1\User;

use App\Rules\StringOrImageRule;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'    => [
                'sometimes',
                'string',
                'min:3',
                'alpha_num',
                Rule::unique('users')->ignore(request()->route('user')),
            ],
            'email'       => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore(request()->route('user')),
            ],
            'password'    => 'nullable|string|min:8|confirmed',
            'leader_id'   => 'nullable|uuid|exists:users,id',
            'role'        => [
                'required',
                'string',
                Rule::in(User::getRules()),
            ],
            'avatar'      => [
                'nullable',
                new StringOrImageRule,
            ],
            'description' => 'nullable|string',
        ];
    }
}
