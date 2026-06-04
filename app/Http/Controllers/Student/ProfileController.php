<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil mahasiswa.
     */
    public function index()
    {
        return view('student.profilestudent');
    }

    /**
     * Update profil mahasiswa (nama, phone, study_program).
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $validated['name'],
        ]);

        if ($user->student) {
            $user->student->update([
                'phone_number' => $validated['phone_number'],
            ]);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Tampilkan halaman ubah password.
     */
    public function showChangePassword()
    {
        return view('student.setprofilestudent');
    }

    /**
     * Proses ubah password mahasiswa.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->update([
            'password' => $request->password,
        ]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
