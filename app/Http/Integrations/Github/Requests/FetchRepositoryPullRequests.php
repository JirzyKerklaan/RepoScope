<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchRepositoryPullRequests extends Request
{
    public function __construct(
        private readonly string $owner,
        private readonly string $repo,
        private readonly int $page = 1
    ) {
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
        return "/repos/{$this->owner}/{$this->repo}/pulls?page={$this->page}&per_page=100&state=all";
    }
}
