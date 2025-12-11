<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class PutCollaborator extends Request
{
    public function __construct(
        private readonly string $owner,
        private readonly string $repo,
        private readonly string $username,
    ) {
    }

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/repos/{$this->owner}/{$this->repo}/collaborators/{$this->username}";
    }
}
