<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrequentMemberController;
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

    Route::prefix('members')->group(function () {
        Route::get('', [FrequentMemberController::class, 'getMembers'])->name('member');
        Route::get('{username}', [FrequentMemberController::class, 'getMember'])->name('member');
        Route::put('', [FrequentMemberController::class, 'putMember'])->name('member.put');
    });
});
