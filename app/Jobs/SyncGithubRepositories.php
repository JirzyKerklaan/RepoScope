<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\RepositoryService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SyncGithubRepositories implements ShouldQueue
{
    use Dispatchable, Queueable;

    protected User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(RepositoryService $service): void
    {
        Log::info('start fetching & saving repositories');
        $service->fetchAndSave($this->user);
    }
}
