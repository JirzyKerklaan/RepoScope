<?php

namespace App\Services;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchUserByUsername;
use App\Models\FrequentMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class FrequentMemberService {
    private readonly GithubApi $connector;

    public function __construct()
    {
        $user = User::find(auth()->id());
        $this->connector = new GithubApi($user->token);
    }

    public function fetchFrequentMember(string $username): array
    {
        $response = $this->connector->send(new FetchUserByUsername($username))->json();

        return [
            'github_id' => $response['id'],
            'username' => $response['login'],
            'display_name' => $response['name'],
            'avatar_url' => $response['avatar_url'],
        ];
    }

    public function putFrequentMember(array $data): JsonResponse
    {
        try {
            $member = FrequentMember::updateOrCreate(
                [
                    'user_id'   => auth()->id(),
                    'github_id' => $data['github_id'],
                ], [
                    'username'      => $data['username'],
                    'display_name'  => $data['display_name'],
                    'avatar_url'    => $data['avatar_url'],
                ]
            );

            $type = $member->wasRecentlyCreated
                ? 'added'
                : 'updated';

            return response()->json([
                'message' => "Frequent member $type successfully",
                'status'  => 200,
                'type' => $type,
                'member'  => $member,
            ]);

        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'This GitHub user already exists in your frequent members.',
                'status'  => 409,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Something went wrong. Please try again later.',
                'status'  => 500,
            ]);
        }
    }
}
