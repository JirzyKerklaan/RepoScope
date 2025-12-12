<?php

namespace App\Services;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchUserByUsername;
use App\Models\User;
use Illuminate\Support\Str;

class CollaboratorService {
    private readonly GithubApi $connector;

    public function __construct()
    {
        $user = User::find(auth()->id());
        $this->connector = new GithubApi($user->token);
    }

    public function fetchCollaborator(string $username): User
    {
        $response = $this->connector->send(new FetchUserByUsername($username))->json();

        $user = User::firstOrNew([
            'github_id' => $response['id'],
        ]);

        $user->name = $response['name'] ?? $response['login'];
        $user->email = $response['email'] ?? $user->email;
        $user->avatar = $response['avatar_url'] ?? $user->avatar;
        $user->url = $response['html_url'] ?? $user->url;
        $user->api_url = $response['url'] ?? $user->api_url;

        if (!$user->exists) {
            $user->password = bcrypt(Str::random(24));
        }

        if ($user->isDirty()) {
            $user->save();
        }

        return $user;
    }

    public function putCollaborator(): void
    {

    }
}
