<?php


namespace App\Timesheets\Traits;


use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait UsingDateRange
{
    /**
     * @param Request $request
     * @return array
     */
    protected function handleDateRange(Request $request): array
    {
        $from = $request->input('from');
        $to = $request->input('to', now()->format('Y-m-d'));
        try {
            $this->validate($request, [
                'from' => 'nullable|date_format:Y-m-d',
                'to'   => 'nullable|date_format:Y-m-d',
            ]);
        } catch (ValidationException $exception) {
            $errors = collect($exception->errors());
            if ($errors->has('from') || $errors->has('to')) {
                $from = null;
                $to = null;
            }
        }

        return [$from, $to];
    }
}
