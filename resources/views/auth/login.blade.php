@extends('layouts.app')

@section('title', 'Repositories - RepoScope')

@section('content')
<div class="min-h-screen bg-slate-950 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-12">
            <div class="bg-indigo-600 p-4 rounded-lg mb-6 shadow-lg shadow-indigo-500/20">
                <icon type="telescope" class="w-12 h-12 text-white"></icon>
            </div>
            <h1 class="text-slate-100 text-3xl mb-2">RepoScope</h1>
            <p class="text-slate-400 text-center">
                Repository Access Management Platform
            </p>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-xl p-8 shadow-xl">
            <div class="mb-8">
                <h2 class="text-slate-100 text-xl mb-2">Welcome!</h2>
                <p class="text-slate-400 text-sm">
                    Sign in to your github account to manage repository access and permissions
                </p>
            </div>

            <a
                href="{{ route('github.redirect') }}"
                class="w-full bg-slate-100 hover:bg-white text-slate-900 py-3 px-2 gap-3 rounded-md shadow-lg flex flex-row items-center justify-center"
            >
                <icon type="github" class="w-5 h-5"></icon>
                Sign in with GitHub
            </a>

            <p class="text-slate-500 text-xs text-center mt-6">
                By signing in, you agree to our Terms of Service and Privacy Policy
            </p>
        </div>
    </div>
</div>
@endsection
