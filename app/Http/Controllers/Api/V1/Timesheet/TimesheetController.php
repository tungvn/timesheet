<?php

namespace App\Http\Controllers\Api\V1\Timesheet;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\Timesheet as TimesheetResource;
use App\Http\Resources\V1\TimesheetCollection;
use App\Http\Responses\V1\DeleteResponse;
use App\Timesheet;
use Illuminate\Auth\Access\AuthorizationException;

class TimesheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return TimesheetCollection
     */
    public function index()
    {
        return new TimesheetCollection(Timesheet::withLeader()->paginate(10));
    }

    /**
     * Display the specified resource.
     *
     * @param Timesheet $timesheet
     * @return TimesheetResource
     * @throws AuthorizationException
     */
    public function show(Timesheet $timesheet)
    {
        $this->authorize('view', $timesheet);

        return new TimesheetResource($timesheet);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Timesheet $timesheet
     * @return DeleteResponse
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroy(Timesheet $timesheet)
    {
        $this->authorize('delete', $timesheet);

        $timesheet->delete();

        return new DeleteResponse(__('messages.timesheet.deleted'));
    }
}
