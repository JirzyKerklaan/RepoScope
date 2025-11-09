@extends('layouts.app')

@section('title', 'Repositories - RepoScope')

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-100">
        @include('_partials.header')
        <main class="max-w-[1800px] mx-auto px-8 py-6">
            @include('_partials.filters')
            <div class="grid grid-cols-12 gap-6 mt-6">
                <div class="col-span-5">
                    <div class="bg-slate-900 rounded-lg border border-slate-800">
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
                    <div class="bg-slate-900 rounded-lg border border-slate-800">
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
                                        <icon type="trendingup" class="w-5 h-5 text-green-400" />
                                    </div>
                                    <div>
                                        <p class="text-sm text-slate-400">Active Pull Requests</p>
                                        <p class="text-slate-100 text-xl">{{$repository->pulls_count}}</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <div class="bg-purple-500/20 p-3 rounded-lg">
                                        <icon type="gitcommit" class="w-5 h-5 text-purple-400" />
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

{{--                        {/* Members List */}--}}
{{--                        <div class="p-6">--}}
{{--                            <div class="flex items-center justify-between mb-4">--}}
{{--                                <h3 class="text-slate-100">Members with Access</h3>--}}
{{--                                <Badge variant="outline" class="bg-slate-800 border-slate-700 text-slate-300">--}}
{{--                                    {members.length} members--}}
{{--                                </Badge>--}}
{{--                            </div>--}}

{{--                            <ScrollArea class="h-[calc(100vh-680px)]">--}}
{{--                                <div class="space-y-3">--}}
{{--                                    {members.map((member) => (--}}
{{--                                    <div--}}
{{--                                        key={member.id}--}}
{{--                                        class="flex items-center gap-4 p-4 rounded-lg bg-slate-800/50 border border-slate-700/50 hover:bg-slate-800 hover:border-slate-700 transition-all"--}}
{{--                                    >--}}
{{--                                        <Avatar class="w-11 h-11">--}}
{{--                                            <AvatarImage src={member.avatar} alt={member.name} />--}}
{{--                                            <AvatarFallback class="bg-indigo-600 text-white">--}}
{{--                                                {member.name.charAt(0)}--}}
{{--                                            </AvatarFallback>--}}
{{--                                        </Avatar>--}}

{{--                                        <div class="flex-1 min-w-0">--}}
{{--                                            <div class="flex items-center gap-2 mb-1">--}}
{{--                                                <p class="text-slate-100">{member.name}</p>--}}
{{--                                                <Badge--}}
{{--                                                    variant="outline"--}}
{{--                                                    class={member.role === 'admin'--}}
{{--                                                ? 'bg-purple-500/20 text-purple-300 border-purple-500/50'--}}
{{--                                                : 'bg-slate-700 border-slate-600 text-slate-300'--}}
{{--                                                }--}}
{{--                                                >--}}
{{--                                                {member.role}--}}
{{--                                                </Badge>--}}
{{--                                            </div>--}}
{{--                                            <p class="text-sm text-slate-500 truncate">{member.email}</p>--}}
{{--                                        </div>--}}

{{--                                        <Separator orientation="vertical" class="h-12 bg-slate-700" />--}}

{{--                                        <div class="flex items-center gap-6 text-sm">--}}
{{--                                            <div>--}}
{{--                                                <p class="text-slate-500 text-xs mb-1">Permission</p>--}}
{{--                                                <Badge--}}
{{--                                                    variant="outline"--}}
{{--                                                    class={getPermissionColor(member.access.permission)}--}}
{{--                                                >--}}
{{--                                                    {getPermissionLabel(member.access.permission)}--}}
{{--                                                </Badge>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-right">--}}
{{--                                                <p class="text-slate-500 text-xs mb-1">Commits</p>--}}
{{--                                                <p class="text-slate-100">{member.access.commitCount}</p>--}}
{{--                                            </div>--}}

{{--                                            <div class="text-right min-w-[100px]">--}}
{{--                                                <p class="text-slate-500 text-xs mb-1">Last Commit</p>--}}
{{--                                                <p class="text-slate-400 text-xs">{member.access.lastCommit}</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    ))}--}}
{{--                                </div>--}}
{{--                            </ScrollArea>--}}
{{--                        </div>--}}
                        @endif
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
