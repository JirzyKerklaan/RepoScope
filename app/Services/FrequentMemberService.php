<?php

namespace App\Services;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchUserByUsername;
use App\Models\User;

class FrequentMemberService {
    private readonly GithubApi $connector;

    public function __construct()
    {
        $user = User::find(auth()->id());
        $this->connector = new GithubApi($user->token);
    }

    public function fetchCollaborator(string $username): array
    {
        $response = $this->connector->send(new FetchUserByUsername($username))->json();

        return [
            'github_id' => $response['id'],
            'username' => $response['login'],
            'display_name' => $response['name'],
            'avatar_url' => $response['avatar_url'],
        ];
    }

    public function putCollaborator($data): void
    {

    }
}
