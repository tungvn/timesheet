<?php

namespace App\Http\Requests\Api\V1\User;

use App\Rules\StringOrImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => [
                'sometimes',
                'string',
                'min:3',
                'alpha_num',
                Rule::unique('users')->ignore(request()->route('user')),
            ],
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore(request()->route('user')),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'leader_id' => 'nullable|uuid|exists:users,id',
            'avatar' => ['nullable', new StringOrImageRule],
            'description' => 'nullable|string',
        ];
    }
}
