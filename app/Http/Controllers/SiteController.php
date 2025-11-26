<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SiteController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $allLanguages = $user->repositories()
            ->select('language')
            ->distinct()
            ->pluck('language')
            ->filter()
            ->values()
            ->toArray();

        $selectedLanguage = $request->query('language', 'all');
        $filter = $request->query('filter');
        $private = $request->query('private');

        $repositories = $user->repositories()
            ->with(['users'])
            ->when($filter, function ($builder, $filter) {
                $builder->filters($filter);
            })
            ->when($private !== null && $private !== 'all', function ($builder) use ($private) {
                $builder->visibility(filter_var($private, FILTER_VALIDATE_BOOLEAN));
            })
            ->when($selectedLanguage !== 'all', fn($q) =>
            $q->where('language', $selectedLanguage)
            )
            ->orderBy('last_pushed_at', 'desc')
            ->get();

//        $repositories = auth()->user()->repositories()->orderBy('name')->get();

        return view('home', [
            'repositories' => $repositories,
            'user' => auth()->user(),
            'filter' => $filter ?? '',
            'selectedLanguage' => $selectedLanguage,
            'allLanguages'     => $allLanguages,
            'private' => $private ?? 'all',
        ]);
    }
}
