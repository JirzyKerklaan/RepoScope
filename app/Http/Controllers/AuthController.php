<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    private AuthService $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function redirectToGithub()
    {
        return Socialite::driver('github')
            ->scopes([
                'read:user',
                'user:email',
                'repo',
                'read:org',
            ])
            ->with(['prompt' => 'consent'])
            ->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();
        } catch (\Exception $e) {
            return redirect('/login')->withErrors('Unable to login using GitHub.');
        }

        $user = $this->authService->findOrCreateGithubUser($githubUser);

        Auth::login($user, true);

        return redirect()->route('home');
    }
}
