<?php

namespace App\Services;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchRepositories;
use App\Models\Repository;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Saloon\Http\Connector;

class RepositoryService
{
    public function fetchAndSave(User $user): void
    {
        $page = 1;

        do {
            $forge = new GithubApi($user->token);
            $request = (new FetchRepositories($page));

            $response = $forge->send($request)->throw()->json();

            Log::info($response);
            foreach ($response as $repoData) {
                Repository::updateOrCreate(
                    ['github_id' => $repoData['id']],
                    [
                        'user_id' => $user->id,
                        'name' => $repoData['name'],
                        'private' => $repoData['private'],
                        'description' => $repoData['description'],
                        'html_url' => $repoData['html_url'],
                        'default_branch' => $repoData['default_branch'],
                        'last_synced_at' => now(),
                    ]
                );
            }

            $page++;
        } while (count($response) === 100);
    }
}
