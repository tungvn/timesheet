<?php

namespace App\Policies;

use App\Timesheet;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TimesheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Timesheet $timesheet
     * @return mixed
     */
    public function view(User $user, Timesheet $timesheet)
    {
        return $this->isTimesheetOfFollowers($user, $timesheet);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Timesheet $timesheet
     * @return mixed
     */
    public function viewByMe(User $user, Timesheet $timesheet)
    {
        return $timesheet->created_by === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Timesheet $timesheet
     * @return mixed
     */
    public function delete(User $user, Timesheet $timesheet)
    {
        return $this->isTimesheetOfFollowers($user, $timesheet);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Timesheet $timesheet
     * @return mixed
     */
    public function deleteByMe(User $user, Timesheet $timesheet)
    {
        return $timesheet->created_by === $user->id;
    }

    /**
     * Determine whether the user can approve the model.
     *
     * @param User $user
     * @param Timesheet $timesheet
     * @return mixed
     */
    public function approve(User $user, Timesheet $timesheet)
    {
        return $this->isTimesheetOfFollowers($user, $timesheet);
    }

    /**
     * @param User $user
     * @param Timesheet $timesheet
     * @return bool
     */
    private function isTimesheetOfFollowers(User $user, Timesheet $timesheet)
    {
        return in_array($user->id, $timesheet->notifiers->map->id);
    }
}
