<?php

use App\Http\Controllers\Admin\SmsController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\ContributorsController;
use App\Http\Controllers\SuperAdmin\LogsController;
use App\Http\Controllers\SuperAdmin\SettingsController;
use App\Http\Controllers\SuperAdmin\UsersController;
use App\Models\Contributor;
use App\Models\Log;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'roles' => Role::all(),
        'stats' => [
            'total' => Contributor::count(),
            'invited' => Contributor::where('status', 'invited')->count(),
            'attended' => Contributor::where('status', 'attended')->count(),
            'not_attended' => Contributor::where('status', 'not_attended')->count(),
            'seats' => (int) Contributor::sum('assigned_seats'),
        ],
        'recentActivity' => Log::latest('action_time')->limit(6)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::post('/users', [UsersController::class, 'create'])->name('users.store');
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/logs', [LogsController::class, 'index'])->name('logs.index');
});

Route::middleware(['auth', 'verified', 'role:admin|superadmin'])->group(function () {
    Route::get('/contributors', [ContributorsController::class, 'index'])->name('contributors.index');
    Route::post('/contributors', [ContributorsController::class, 'store'])->name('contributors.store');
    Route::post('/contributors/import', [ContributorsController::class, 'import'])->name('contributors.import');
    Route::get('/contributors/template', [ContributorsController::class, 'template'])->name('contributors.template');
    Route::get('/contributors/{contributor}/edit', [ContributorsController::class, 'edit'])->name('contributors.edit');
    Route::put('/contributors/{contributor}', [ContributorsController::class, 'update'])->name('contributors.update');
    Route::post('/contributors/{contributor}/send-sms', [SmsController::class, 'sendSms'])->name('contributors.send-sms');
});

Route::middleware(['auth', 'verified', 'role:superadmin'])->group(function () {
    Route::delete('/contributors/{contributor}', [ContributorsController::class, 'destroy'])->name('contributors.destroy');
    Route::get('/contributors/trashed', [ContributorsController::class, 'trashed'])->name('contributors.trashed');
    Route::post('/contributors/{id}/restore', [ContributorsController::class, 'restore'])->name('contributors.restore');
    Route::get('/contributors/{contributor}/sms-preview', [SmsController::class, 'smsPreview'])->name('contributors.sms-preview');
});

Route::middleware(['auth', 'verified', 'role:admin|superadmin|checker'])->group(function () {
    Route::get('/contributors/list', [ContributorsController::class, 'list'])->name('contributors.list');
    Route::post('/contributors/{contributor}/attend', [ContributorsController::class, 'markAttended'])->name('contributors.attend');
    Route::patch('/contributors/{contributor}/seats', [ContributorsController::class, 'updateSeats'])->name('contributors.seats');
});

Route::get('/invitations/{code}', [InvitationController::class, 'show'])->name('invitations.show');

Route::middleware(['auth', 'verified', 'role:checker|admin|superadmin'])->group(function () {
    Route::get('/verify/{code}', [InvitationController::class, 'verify'])->name('invitations.verify');
    Route::post('/verify/{code}', [InvitationController::class, 'confirm'])->name('invitations.confirm');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
