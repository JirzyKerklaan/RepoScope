<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\RepositoryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncGithubRepositories implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(RepositoryService $repositoryService): void
    {
        $repositoryService->fetchAndSave($this->user);
    }
}
