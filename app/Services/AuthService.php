<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Crypt;

class AuthService
{
    public function findOrCreateGithubUser($githubUser): User
    {
        return User::updateOrCreate(
            ['github_id' => $githubUser->id],
            [
                'name' => $githubUser->login ?? $githubUser->nickname ?? $githubUser->name,
                'email' => $githubUser->email ?? null,
                'password' => bcrypt(str()->random(24)),
                'avatar' => $githubUser->avatar,
                'url' => $githubUser->user['html_url'],
                'api_url' => $githubUser->user['url'],
                'token' => $githubUser->token ?? null,
            ]
        );
    }
}
