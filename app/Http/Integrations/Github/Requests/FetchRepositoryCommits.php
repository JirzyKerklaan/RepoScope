<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchRepositoryCommits extends Request
{
    protected string $owner;
    protected string $repo;
    protected int $page;
    public function __construct(
        string $owner,
        string $repo,
        int $page = 1
    ) {
        $this->owner = $owner;
        $this->repo = $repo;
        $this->page = $page;
    }

    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint(): string
    {
        return "/repos/{$this->owner}/{$this->repo}/commits?page={$this->page}&per_page=100&author={$this->owner}";
    }
}
