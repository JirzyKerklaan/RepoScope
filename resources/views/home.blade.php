@extends('layouts.app')

@section('title', 'Repositories - RepoScope')

@section('content')
    <div class="bg-slate-950 text-slate-100 h-screen overflow-hidden">
        @include('_partials.header')
        <main class="max-w-[1800px] mx-auto px-8 py-6 h-full">
            @include('_partials.filters')
            <div class="grid grid-cols-12 gap-6 mt-6">
                <div class="col-span-5">
                    <div class="bg-slate-900 rounded-lg border border-slate-800 max-h-[calc(100vh-175px)] overflow-scroll">
                        <div class="p-4 border-b border-slate-800">
                            <h2 class="text-slate-100">Repositories</h2>
                            <p class="text-sm text-slate-500 mt-1">{{count($repositories)}} repositories</p>
                        </div>

                        <section>
                            <div class="p-2">
                                @if($repositories->count() <= 0)
                                    <p class="text-sm text-slate-500 mt-1">No repositories found</p>
                                @else
                                    @foreach($repositories as $repository)
                                        @include('_partials.repository')
                                    @endforeach
                                @endif
                            </div>
                        </section>
                    </div>
                </div>

                <div class="col-span-7">
                    @if ($repositories->count() > 0)
                        <div class="bg-slate-900 rounded-lg border border-slate-800 max-h-[calc(100vh-175px)] overflow-scroll">
                            <div class="p-6 border-b border-slate-800">
                                <div class="flex items-start justify-between mb-4">
                                    <div class="flex items-center gap-3">

                                        @if($repository->private)
                                            <icon type="lock" class="w-6! h-6! text-indigo-400"></icon>
                                        @else
                                            <icon type="globe" class="w-6! h-6! text-indigo-400"></icon>
                                        @endif
                                        <div>
                                            <h2 class="text-slate-100 text-2xl">{{$repository->name}}</h2>
    {{--                                        Description ?--}}
                                        </div>
                                    </div>
                                    <x-badge
                                        variant="outline"
                                        class="{{$repository->private ? 'bg-orange-500/20 text-orange-300 border-orange-500/50' : 'bg-green-500/20 text-green-300 border-green-500/50'}}">
                                        {{$repository->private ? 'Private' : 'Public'}}
                                    </x-badge>
                                </div>
                                <div class="grid grid-cols-4 gap-4 mt-6">
                                    <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                                        <div class="flex items-center gap-2 text-slate-400 mb-2">
                                            <icon type="gitbranch" class="w-4 h-4"></icon>
                                            <span class="text-sm">Branches</span>
                                        </div>
                                        <p class="text-slate-100 text-2xl">{{$repository->branch_count}}</p>
                                    </section>

                                    <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                                        <div class="flex items-center gap-2 text-slate-400 mb-2">
                                            <icon type="gitfork" class="w-4 h-4"></icon>
                                            <span class="text-sm">Pull requests</span>
                                        </div>
                                        <p class="text-slate-100 text-2xl">{{$repository->pulls_count}}</p>
                                    </section>

                                    <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                                        <div class="flex items-center gap-2 text-slate-400 mb-2">
                                            <icon type="gitcommit" class="w-4 h-4"></icon>
                                            <span class="text-sm">Commits</span>
                                        </div>
                                        @php
                                            $totalCommits = $repository->users->sum('pivot.commit_count');
                                        @endphp
                                        <p class="text-slate-100 text-2xl">{{$totalCommits}}</p>
                                    </section>

                                    <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                                        <div class="flex items-center gap-2 text-slate-400 mb-2">
                                            <icon type="harddrive" class="w-4 h-4"></icon>
                                            <span class="text-sm">Size</span>
                                        </div>
                                        <p class="text-slate-100 text-2xl">{{$repository->size}} MB</p>
                                    </section>
                                </div>
                                <div class="flex items-center gap-6 mt-4 text-sm text-slate-400">
                                    <div class="flex items-center gap-2">
                                        <icon type="calendar" class="w-4 h-4 text-slate-400"></icon>
                                        <span>Updated {{$repository->last_pushed_at->diffForHumans()}}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                        <span>{{$repository->language}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6 border-b border-slate-800 bg-slate-800/30">
                                <div class="grid grid-cols-3 gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="bg-indigo-500/20 p-3 rounded-lg">
                                            <icon type="users" class="w-5 h-5 text-indigo-400"></icon>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-400">Total Access</p>
                                            <p class="text-slate-100 text-xl">{{$repository->users->count()}}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="bg-green-500/20 p-3 rounded-lg">
                                            <icon type="trendingup" class="w-5 h-5 text-green-400"></icon>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-400">Active Pull Requests</p>
                                            <p class="text-slate-100 text-xl">{{$repository->pulls_count}}</p>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3">
                                        <div class="bg-purple-500/20 p-3 rounded-lg">
                                            <icon type="gitcommit" class="w-5 h-5 text-purple-400"></icon>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-400">Total Contributions</p>

                                            @php
                                                $totalCommits = $repository->pivot->commit_count;
                                            @endphp
                                            <p class="text-slate-100 text-xl">{{$totalCommits}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if ($repository->users->count() > 0)
                                <div class="p-6 max-h-1/2 overflow-scroll">
                                    <div class="flex items-center justify-between mb-6">
                                        <h3 class="text-slate-100">Members with Access</h3>
                                        <div class="flex gap-4">
                                        <x-badge variant="outline" class="bg-slate-800 border-slate-700 text-slate-300">
                                            {{$repository->users->count()}} members
                                        </x-badge>
                                            <a href="{{$repository->html_url}}/settings/access" target="_blank">
                                                <x-badge variant="outline" class="bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700 transition-all">
                                                    <icon type="plus" class="h-4 w-4 text-slate-300"></icon>
                                                    Add member
                                                </x-badge>
                                            </a>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="space-y-2">
                                            <div class="grid grid-cols-12 gap-4 px-4 pb-3 text-xs text-slate-500 border-b border-slate-800">
                                                <div class="col-span-6">Member</div>
                                                <div class="col-span-2">Permission</div>
                                                <div class="col-span-2 text-center">Commits</div>
                                                <div class="col-span-2 text-center">Pull requests</div>
                                            </div>

                                            @foreach($repository->users as $member)
                                                <div class="grid grid-cols-12 gap-4 items-center p-4 rounded-lg hover:bg-slate-800/50 transition-colors group">
                                                    <div class="col-span-6 flex items-center gap-3">
                                                            <img
                                                                src="{{$member->avatar}}"
                                                                alt="User"
                                                                class="w-10 h-10 rounded-full ring-2 ring-slate-700"
                                                            />
                                                        <div class="min-w-0 flex-1">
                                                            <p class="text-slate-100 truncate">{{ $member->name }}</p>
                                                            <p class="text-xs text-slate-500 truncate">{{$member->email}}</p>
                                                        </div>
                                                    </div>

                                                    <div class="col-span-2">
                                                        <x-badge
                                                            variant="outline"
                                                            class={getPermissionColor(member.access.permission)}
                                                        >
    {{--                                                        {getPermissionLabel(member.access.permission)}--}}
                                                        </x-badge>
                                                    </div>

                                                    <div class="col-span-2 text-center">
                                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-800/50">
                                                            <icon type="gitcommit" class="w-3.5 h-3.5 text-slate-400"></icon>
                                                            <span class="text-slate-100">{{$member->pivot->commit_count}}</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-span-2 text-center">
                                                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-800/50">
                                                            <icon type="gitfork" class="w-3.5 h-3.5 text-slate-400"></icon>
                                                            <span class="text-slate-100">{{$member->pivot->commit_count}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </main>
    </div>
@endsection
