<?php

namespace App\Http\Requests\Api\V1\User;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'username'    => 'required|string|min:3|alpha_num|unique:users',
            'email'       => 'required|email|unique:users',
            'password'    => 'required|string|min:8|confirmed',
            'leader_id'   => 'nullable|uuid|exists:users,id',
            'role'        => [
                'required',
                'string',
                Rule::in(User::getRules()),
            ],
            'avatar'      => 'nullable|image',
            'description' => 'nullable|string',
        ];
    }
}
