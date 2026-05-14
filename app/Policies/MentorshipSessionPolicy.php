<?php

namespace App\Policies;

use App\Models\MentorshipSession;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MentorshipSessionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MentorshipSession $mentorshipSession): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'student') {
            return $user->student->id === $mentorshipSession->internship->student_id;
        }

        if ($user->role === 'lecturer') {
            return $user->lecturer->id === $mentorshipSession->internship->lecturer_id;
        }

        return false;
    }
}
