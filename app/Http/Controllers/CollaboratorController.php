<?php

namespace App\Http\Controllers;

use App\Services\CollaboratorService;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function __construct(private readonly CollaboratorService $collaboratorService)
    {
    }

    public function putCollaborator(): void
    {
        $this->collaboratorService->putCollaborator();
    }
}
