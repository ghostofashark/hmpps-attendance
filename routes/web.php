<?php
use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ContactLogController;
use App\Http\Controllers\DailySickListController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\GovernorDashboardController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AuthorisedViewerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::resource('staff', StaffController::class);
    Route::resource('absences', AbsenceController::class);
    Route::post('absences/{absence}/toggle-daily-list', [AbsenceController::class, 'toggleDailyList'])->name('absences.toggle-daily-list');
    Route::get('absences/{absence}/rtw', [AbsenceController::class, 'rtwWizard'])->name('absences.rtw');
    Route::post('absences/{absence}/contact-logs', [ContactLogController::class, 'store'])->name('contact-logs.store');
    Route::delete('contact-logs/{contactLog}', [ContactLogController::class, 'destroy'])->name('contact-logs.destroy');
    Route::get('daily-sick-list', [DailySickListController::class, 'index'])->name('daily-sick-list');
    Route::get('daily-sick-list/export', [DailySickListController::class, 'export'])->name('daily-sick-list.export');
    Route::post('absences/{absence}/documents/{type}', [DocumentController::class, 'generate'])->name('documents.generate');
    Route::get('governor/dashboard', [GovernorDashboardController::class, 'index'])->name('governor.dashboard');
    Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics');

    // Admin: HOBBA only
    Route::middleware('role:hobba')->prefix('admin')->name('admin.')->group(function () {
        Route::get('authorised-viewers', [AuthorisedViewerController::class, 'index'])->name('authorised-viewers.index');
        Route::post('authorised-viewers', [AuthorisedViewerController::class, 'store'])->name('authorised-viewers.store');
        Route::delete('authorised-viewers/{viewer}', [AuthorisedViewerController::class, 'destroy'])->name('authorised-viewers.destroy');
        Route::post('authorised-viewers/{viewer}/toggle', [AuthorisedViewerController::class, 'toggle'])->name('authorised-viewers.toggle');
    });
});

require __DIR__.'/auth.php';
