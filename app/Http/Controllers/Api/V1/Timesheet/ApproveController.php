<?php

namespace App\Http\Controllers\Api\V1\Timesheet;

use App\Http\Controllers\Controller;
use App\Http\Responses\V1\SuccessfulMessageResponse;
use App\Timesheet;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class ApproveController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @param Timesheet $timesheet
     * @return SuccessfulMessageResponse
     * @throws AuthorizationException
     */
    public function __invoke(Request $request, Timesheet $timesheet)
    {
        $this->authorize('approve', $timesheet);

        $timesheet->update([
            'status' => Timesheet::STATUS_APPROVED,
        ]);

        return new SuccessfulMessageResponse(__('messages.timesheet.approved'));
    }
}
