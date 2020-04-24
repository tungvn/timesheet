<?php

namespace App\Http\Requests\Api\V1\Me\Timesheet;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
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
