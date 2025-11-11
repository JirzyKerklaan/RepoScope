<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchRepositoryCollaborators extends Request
{
    protected string $owner;
    protected string $repo;
    public function __construct(
        string $owner,
        string $repo,
    ) {
        $this->owner = $owner;
        $this->repo = $repo;
    }

    protected Method $method = Method::GET;
    public function resolveEndpoint(): string
    {
        return "/repos/{$this->owner}/{$this->repo}/collaborators";
    }
}
