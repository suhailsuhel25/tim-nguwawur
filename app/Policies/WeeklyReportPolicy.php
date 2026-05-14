<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeeklyReport;
use Illuminate\Auth\Access\Response;

class WeeklyReportPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WeeklyReport $weeklyReport): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'student') {
            return $user->student->id === $weeklyReport->internship->student_id;
        }

        if ($user->role === 'lecturer') {
            return $user->lecturer->id === $weeklyReport->internship->lecturer_id;
        }

        return false;
    }
}
