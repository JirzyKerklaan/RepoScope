<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\SiteController;
use App\Jobs\SyncGithubRepositories;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/auth/github/redirect', [AuthController::class, 'redirectToGithub'])->name('github.redirect');
Route::get('/auth/github/callback', [AuthController::class, 'handleGithubCallback'])->name('github.callback');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [SiteController::class, 'index'])->name('dashboard');

    Route::get('/test', function () {
        SyncGithubRepositories::dispatchSync(auth()->user());
        redirect()->route('dashboard');
    });

    Route::put('/{repository}/collaborator', [CollaboratorController::class, 'putCollaborator'])->name('collaborator.put');

    Route::prefix('member')->group(function () {
        Route::get('', [CollaboratorController::class, 'getMember'])->name('member');
    });
});
