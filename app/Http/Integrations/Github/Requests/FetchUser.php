<?php

namespace App\Http\Integrations\Github\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class FetchUser extends Request
{
    protected string $id;
    public function __construct(
        string $id,
    ) {
        $this->id = $id;
    }

    protected Method $method = Method::GET;
    public function resolveEndpoint(): string
    {
        return "/user/$this->id";
    }
}
