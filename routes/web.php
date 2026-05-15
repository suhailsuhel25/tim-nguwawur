<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    // Notifications Routes
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');

    Route::middleware('role:student')->prefix('mahasiswa')->name('student.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('internships', App\Http\Controllers\Student\InternshipController::class)->only(['index', 'create', 'store']);
        Route::resource('weekly_reports', App\Http\Controllers\Student\WeeklyReportController::class)->only(['index', 'create', 'store', 'show']);
        Route::get('weekly_reports/{weeklyReport}/download', [App\Http\Controllers\Student\WeeklyReportController::class, 'downloadDocument'])->name('weekly_reports.download');

        Route::get('mentorship_sessions', [App\Http\Controllers\Student\MentorshipSessionController::class, 'index'])->name('mentorship_sessions.index');
        Route::get('mentorship_sessions/{mentorshipSession}', [App\Http\Controllers\Student\MentorshipSessionController::class, 'show'])->name('mentorship_sessions.show');

        Route::get('final_grades', [App\Http\Controllers\Student\FinalGradeController::class, 'index'])->name('final_grades.index');
        Route::get('final_grades/{finalGrade}', [App\Http\Controllers\Student\FinalGradeController::class, 'show'])->name('final_grades.show');
    });

    Route::middleware('role:lecturer')->prefix('dosen')->name('lecturer.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Lecturer\DashboardController::class, 'index'])->name('dashboard');

        Route::get('internships', [App\Http\Controllers\Lecturer\InternshipController::class, 'index'])->name('internships.index');
        Route::get('students', [App\Http\Controllers\Lecturer\InternshipController::class, 'students'])->name('students.index');
        Route::get('internships/{internship}', [App\Http\Controllers\Lecturer\InternshipController::class, 'show'])->name('internships.show');
        Route::put('internships/{internship}/status', [App\Http\Controllers\Lecturer\InternshipController::class, 'updateStatus'])->name('internships.update_status');
        Route::post('internships/{internship}/grade', [App\Http\Controllers\Lecturer\InternshipController::class, 'grade'])->name('internships.grade');

        Route::get('weekly_reports', [App\Http\Controllers\Lecturer\WeeklyReportController::class, 'index'])->name('weekly_reports.index');
        Route::get('weekly_reports/{weeklyReport}', [App\Http\Controllers\Lecturer\WeeklyReportController::class, 'show'])->name('weekly_reports.show');
        Route::put('weekly_reports/{weeklyReport}/status', [App\Http\Controllers\Lecturer\WeeklyReportController::class, 'updateStatus'])->name('weekly_reports.update_status');
        Route::get('weekly_reports/{weeklyReport}/download', [App\Http\Controllers\Lecturer\WeeklyReportController::class, 'downloadDocument'])->name('weekly_reports.download');

        Route::resource('mentorship_sessions', App\Http\Controllers\Lecturer\MentorshipSessionController::class)->except(['destroy'])->parameters(['mentorship_sessions' => 'mentorshipSession']);
        Route::put('mentorship_sessions/{mentorshipSession}/complete', [App\Http\Controllers\Lecturer\MentorshipSessionController::class, 'complete'])->name('mentorship_sessions.complete');
        Route::put('mentorship_sessions/{mentorshipSession}/cancel', [App\Http\Controllers\Lecturer\MentorshipSessionController::class, 'cancel'])->name('mentorship_sessions.cancel');
        
        Route::get('documents/{document}', [App\Http\Controllers\Lecturer\InternshipController::class, 'viewDocument'])->name('internships.view_document');
        Route::get('students/{internship}', [App\Http\Controllers\Lecturer\InternshipController::class, 'studentShow'])->name('students.show');
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::resource('companies', App\Http\Controllers\Admin\CompanyController::class);
        Route::resource('periods', App\Http\Controllers\Admin\InternshipPeriodController::class);

        Route::get('reports/activities', [App\Http\Controllers\Admin\ReportController::class, 'activities'])->name('reports.activities');
        Route::get('reports/grades', [App\Http\Controllers\Admin\ReportController::class, 'grades'])->name('reports.grades');
    });
});
