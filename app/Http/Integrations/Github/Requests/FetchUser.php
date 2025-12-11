<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchUser extends Request
{
    public function __construct(
        private readonly string $id,
    ) {
    }

    protected Method $method = Method::GET;
    public function resolveEndpoint(): string
    {
        return "/user/$this->id";
    }
}
