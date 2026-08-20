<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\ContributorsController;
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
});

Route::middleware(['auth', 'verified', 'role:admin|superadmin'])->group(function () {
    Route::get('/contributors', [ContributorsController::class, 'index'])->name('contributors.index');
    Route::post('/contributors', [ContributorsController::class, 'store'])->name('contributors.store');
    Route::post('/contributors/import', [ContributorsController::class, 'import'])->name('contributors.import');
    Route::get('/contributors/template', [ContributorsController::class, 'template'])->name('contributors.template');
    Route::get('/contributors/{contributor}/edit', [ContributorsController::class, 'edit'])->name('contributors.edit');
    Route::put('/contributors/{contributor}', [ContributorsController::class, 'update'])->name('contributors.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
