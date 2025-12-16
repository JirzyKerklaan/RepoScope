<?php

namespace App\Http\Controllers;

use App\Http\Requests\PutFrequentMemberRequest;
use App\Models\FrequentMember;
use App\Services\FrequentMemberService;
use Illuminate\Http\JsonResponse;

class FrequentMemberController extends Controller
{
    public function __construct(private readonly FrequentMemberService $collaboratorService)
    {
    }

    public function getMembers(): array
    {
        $frequentMembers = FrequentMember::all();
        return [
            'frequentMembers' => $frequentMembers,
        ];
    }

    public function getMember(string $username): JsonResponse
    {
        if (!$username) {
            return response()->json(['error' => 'Username is required'], 400);
        }

        $user = $this->collaboratorService->fetchCollaborator($username);

        return response()->json($user);
    }


    public function putMember(PutFrequentMemberRequest $request): void
    {
        $this->collaboratorService->putCollaborator($request->validated());
    }
}
