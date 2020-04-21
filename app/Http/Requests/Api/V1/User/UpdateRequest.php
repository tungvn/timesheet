<?php

namespace App\Http\Requests\Api\V1\User;

use Illuminate\Foundation\Http\FormRequest;

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
            'username'    => 'sometimes|string|min:3|alpha_num',
            'email'       => 'sometimes|email|unique:users',
            'password'    => 'sometimes|string|min:8|confirmed',
            'leader_id'   => 'nullable|uuid|exists:users,id',
            'avatar'      => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
