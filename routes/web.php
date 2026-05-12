<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::middleware('role:student')->prefix('mahasiswa')->name('student.')->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        })->name('dashboard');

        Route::resource('internships', App\Http\Controllers\Student\InternshipController::class)->only(['index', 'create', 'store']);
    });

    Route::middleware('role:lecturer')->prefix('dosen')->name('lecturer.')->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen.dashboard');
        })->name('dashboard');

        Route::get('internships', [App\Http\Controllers\Lecturer\InternshipController::class, 'index'])->name('internships.index');
        Route::get('internships/{internship}', [App\Http\Controllers\Lecturer\InternshipController::class, 'show'])->name('internships.show');
        Route::put('internships/{internship}/status', [App\Http\Controllers\Lecturer\InternshipController::class, 'updateStatus'])->name('internships.update_status');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class);
        Route::resource('periods', App\Http\Controllers\Admin\InternshipPeriodController::class);
    });
});
