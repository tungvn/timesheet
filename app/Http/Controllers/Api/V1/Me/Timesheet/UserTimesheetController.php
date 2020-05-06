<?php

namespace App\Http\Controllers\Api\V1\Me\Timesheet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Me\Timesheet\StoreRequest;
use App\Http\Requests\Api\V1\Me\Timesheet\UpdateRequest;
use App\Http\Resources\V1\Timesheet as TimesheetResource;
use App\Http\Resources\V1\TimesheetCollection;
use App\Http\Responses\V1\DeleteResponse;
use App\Timesheet;
use App\Timesheets\Traits\UsingDateRange;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class UserTimesheetController extends Controller
{
    use UsingDateRange;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return TimesheetCollection
     */
    public function index(Request $request)
    {
        $builder = Timesheet::query()->ownedBy();

        list($from, $to) = $this->handleDateRange($request);

        return new TimesheetCollection($builder->withDateRange($from, $to)->orderByDesc('created_at')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return TimesheetResource
     */
    public function store(StoreRequest $request)
    {
        return new TimesheetResource(Timesheet::create($request->all()));
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
        $this->authorize('viewByMe', $timesheet);

        return new TimesheetResource($timesheet);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Timesheet $timesheet
     * @return TimesheetResource
     */
    public function update(UpdateRequest $request, Timesheet $timesheet)
    {
        return new TimesheetResource(tap($timesheet)->update($request->all()));
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
        $this->authorize('deleteByMe', $timesheet);

        $timesheet->delete();

        return new DeleteResponse(__('messages.timesheet.deleted'));
    }
}
