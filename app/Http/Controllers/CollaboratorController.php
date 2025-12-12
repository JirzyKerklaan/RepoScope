<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CollaboratorService;
use Illuminate\Http\Request;

class CollaboratorController extends Controller
{
    public function __construct(private readonly CollaboratorService $collaboratorService)
    {
    }

    public function getMember(Request $request)
    {
        $username = $request->query('username');
        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $user = $this->collaboratorService->fetchCollaborator($username);

        return response()->json($user);
    }


    public function putCollaborator(): void
    {
        $this->collaboratorService->putCollaborator();
    }
}
