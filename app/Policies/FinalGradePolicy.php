<?php

namespace App\Policies;

use App\Models\FinalGrade;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class FinalGradePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, FinalGrade $finalGrade): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'student') {
            return $user->student->id === $finalGrade->internship->student_id;
        }

        if ($user->role === 'lecturer') {
            return $user->lecturer->id === $finalGrade->internship->lecturer_id;
        }

        return false;
    }
}
