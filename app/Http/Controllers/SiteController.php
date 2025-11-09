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
        $filter = $request->query('filter');
        $user = auth()->user();

        $repositories = $user->repositories()
            ->when($filter, function ($builder, $filter) {
                $builder->filters($filter);
            })
            ->orderBy('last_pushed_at', 'desc')
            ->get();

//        $repositories = auth()->user()->repositories()->orderBy('name')->get();

        return view('home', [
            'repositories' => $repositories,
            'user' => auth()->user(),
            'filter' => $filter ?? '',
        ]);
    }
}
