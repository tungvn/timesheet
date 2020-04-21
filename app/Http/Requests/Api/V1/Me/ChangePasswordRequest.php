<?php

namespace App\Http\Requests\Api\V1\Me;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    /** @var \App\User */
    protected $user;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null)
    {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->user = auth()->user();
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user->can('updateMe', User::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'     => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, $this->user->getAuthPassword())) {
                        $fail(__('validation.password'));
                    }
                },
            ],
            'new_password' => 'required|string|min:8|confirmed',
        ];
    }
}
