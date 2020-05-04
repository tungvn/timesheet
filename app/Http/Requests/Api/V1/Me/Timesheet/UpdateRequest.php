<?php

namespace App\Http\Requests\Api\V1\Me\Timesheet;

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
        return auth()->id() === request()->route('timesheet')->author->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date'               => 'required|string|date_format:Y-m-d',
            'doing'              => 'required|array',
            'doing.*.task_id'    => 'nullable|string',
            'doing.*.content'    => 'nullable|string',
            'doing.*.spend_time' => 'nullable|string',
            'problem'            => 'required|string',
            'plan'               => 'required|string',
        ];
    }
}
