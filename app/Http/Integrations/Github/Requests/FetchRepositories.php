<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchRepositories extends Request
{
    public function __construct(protected readonly string|int $page = 1)
    {
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
        return '/user/repos';
    }

    public function defaultQuery(): array
    {
        return [
            'visibility' => 'all',
            'affiliation' => 'owner,collaborator',
            'per_page' => 100,
            'page' => $this->page,
        ];
    }
}
