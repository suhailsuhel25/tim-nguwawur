<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('internships', App\Http\Controllers\InternshipController::class);

    Route::middleware('role:student')->prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', function () {
            return view('mahasiswa.dashboard');
        });
    });

    Route::middleware('role:lecturer')->prefix('dosen')->group(function () {
        Route::get('/dashboard', function () {
            return view('dosen.dashboard');
        });
    });

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });
    });
});
