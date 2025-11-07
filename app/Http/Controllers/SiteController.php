<?php

namespace App\Http\Controllers;

use App\Http\Integrations\Github\GithubApi;
use App\Http\Integrations\Github\Requests\FetchRepositories;

class SiteController extends Controller
{
    public function index()
    {
        $repositories = auth()->user()->repositories()->orderBy('name')->get();

        return view('home', [
            'repositories' => $repositories,
            'user' => auth()->user(),
        ]);
    }
}
