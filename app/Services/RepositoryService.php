<?php

namespace App\Services;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchRepositories;
use App\Http\Integrations\Github\Requests\FetchRepositoryBranches;
use App\Http\Integrations\Github\Requests\FetchRepositoryCommits;
use App\Http\Integrations\Github\Requests\FetchRepositoryPullRequests;
use App\Models\Repository;
use App\Models\User;
use Carbon\Carbon;

class RepositoryService
{
    public function fetchAndSave(User $user): void
    {
        $page = 1;

        do {
            $forge = new GithubApi($user->token);
            $request = (new FetchRepositories($page));

            $response = $forge->send($request)->throw()->json();

            foreach ($response as $repoData) {
                $repository = Repository::updateOrCreate(
                    ['github_id' => $repoData['id']],
                    [
                        'name' => $repoData['name'],
                        'private' => $repoData['private'],
                        'description' => $repoData['description'],
                        'html_url' => $repoData['html_url'],
                        'default_branch' => $repoData['default_branch'],
                        'language' => $repoData['language'],
                        'last_pushed_at' => Carbon::parse($repoData['pushed_at']),
                        'last_synced_at' => now(),
                        'size' => $repoData['size'],
                    ]
                );

                $this->fetchRepositoryCommits($forge, $user, $repository);
                $this->fetchRepositoryBranches($forge, $user, $repository);
                $this->fetchRepositoryPullRequests($forge, $user, $repository);
            }

            $page++;
        } while (count($response) === 100);
    }

    public function fetchRepositoryCommits($forge, User $user, Repository $repository): void
    {
        $page = 1;
        $commitCount = 0;

        do {
            $request = new FetchRepositoryCommits($user->name, $repository->name, $page);
            $response = $forge->send($request)->throw()->json();

            $commitCount += count($response);

            $page++;
        } while (count($response) === 100);

        $user->repositories()->syncWithoutDetaching([
            $repository->id => ['commit_count' => $commitCount],
        ]);

    }

    public function fetchRepositoryBranches($forge, User $user, Repository $repository): void
    {
        $page = 1;
        $branchCount = 0;

        do {
            $request = new FetchRepositoryBranches($user->name, $repository->name, $page);
            $response = $forge->send($request)->throw()->json();

            $branchCount += count($response);

            $page++;
        } while (count($response) === 100);

        $repository->update(['branch_count' => $branchCount]);
    }

    public function fetchRepositoryPullRequests($forge, User $user, Repository $repository): void
    {
        $page = 1;
        $pullsCount = 0;

        do {
            $request = new FetchRepositoryPullRequests($user->name, $repository->name, $page);
            $response = $forge->send($request)->throw()->json();

            $pullsCount += count($response);

            $page++;
        } while (count($response) === 100);

        $repository->update(['pulls_count' => $pullsCount]);
    }
}
