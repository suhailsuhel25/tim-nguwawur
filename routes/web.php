<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard/mahasiswa', function () {
    return view('dashboard.mahasiswa');
});

Route::get('/dashboard/dosen', function () {
    return view('dashboard.dosen');
});

Route::get('/dashboard/admin', function () {
    return view('dashboard.admin');
});
