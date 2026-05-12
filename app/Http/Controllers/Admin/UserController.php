<?php

// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of users (students & lecturers).
     */
    public function index()
    {
        $query = User::with(['student', 'lecturer'])
            ->whereIn('role', ['student', 'lecturer']);

        if (request()->filled('search')) {
            $q = request('search');
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%");
            });
        }

        if (request()->filled('role')) {
            $query->where('role', request('role'));
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name'     => $request->name,
                'username' => $request->username,
                'password' => $request->password, // auto-hashed by cast
                'role'     => $request->role,
            ]);

            if ($request->role === 'student') {
                Student::create([
                    'user_id'       => $user->id,
                    'study_program' => $request->study_program,
                    'cohort_year'   => $request->cohort_year,
                    'phone_number'  => $request->phone_number,
                ]);
            } elseif ($request->role === 'lecturer') {
                Lecturer::create([
                    'user_id'      => $user->id,
                    'phone_number' => $request->phone_number,
                ]);
            }
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load(['student', 'lecturer']);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        DB::transaction(function () use ($request, $user) {
            $data = [
                'name'     => $request->name,
                'username' => $request->username,
            ];

            if ($request->filled('password')) {
                $data['password'] = $request->password;
            }

            $user->update($data);

            if ($user->role === 'student' && $user->student) {
                $user->student->update([
                    'study_program' => $request->study_program,
                    'cohort_year'   => $request->cohort_year,
                    'phone_number'  => $request->phone_number,
                ]);
            } elseif ($user->role === 'lecturer' && $user->lecturer) {
                $user->lecturer->update([
                    'phone_number' => $request->phone_number,
                ]);
            }
        });

        return redirect()->route('admin.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
