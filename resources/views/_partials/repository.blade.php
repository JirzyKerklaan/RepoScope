@php
    if($repository->name === 'tep-cms') {
        $active = true;
    } else {
        $active = false;
    }
@endphp

<div class="w-full text-left p-4 rounded-lg mb-2 transition-all {{ $active ? 'bg-indigo-600/20 border border-indigo-500/50' : 'bg-slate-800/50 border border-slate-700/50 hover:bg-slate-800 hover:border-slate-700' }}">
    <div class="flex items-start justify-between mb-2">
        <div class="flex items-center gap-2 flex-1 min-w-0">
            @if($repository->private)
                <icon type="lock" class="w-4 h-4 text-slate-400 flex-shrink-0"></icon>
            @else
                <icon type="globe" class="w-4 h-4 text-slate-400 flex-shrink-0"></icon>
            @endif
            <h3 class="text-indigo-100">
                {{$repository->name}}
            </h3>
        </div>
        <x-badge
            variant="outline"
            class="ml-2 flex-shrink-0 {{ $active ? 'bg-indigo-500/20 border-indigo-400 text-indigo-200' : 'bg-slate-700 border-slate-600 text-slate-300' }}"
        >
            {{$repository->language}}
        </x-badge>
    </div>

    <p class="text-sm text-slate-400 mb-3 line-clamp-1">
        {{$repository->description ?? '...'}}
    </p>

    <div class="flex items-center gap-4 text-xs text-slate-500">
        <div class="flex items-center gap-1">
            <icon type="gitbranch" class="w-4 h-4"></icon>
            <span>{{$repository->branch_count}}</span>
        </div>
        <div class="flex items-center gap-1">
            <icon type="gitfork" class="w-4 h-4"></icon>
            <span>{{$repository->pulls_count}}</span>
        </div>
        <div class="flex items-center gap-1">
            @php
                $totalCommits = $repository->users->sum('pivot.commit_count');
            @endphp
            <icon type="gitcommit" class="w-4 h-4"></icon>
            <span>{{$totalCommits}}</span>
        </div>
        <div class="flex items-center gap-1 ml-auto">
            <span class="text-indigo-300 text-slate-400">
                {{$repository->users->count()}} {{$repository->users->count() === 1 ? 'user' : 'users'}}
            </span>
        </div>
    </div>

    <div class="flex items-center gap-1 text-xs text-slate-500 mt-2">
        <icon type="clock"></icon>
        <span>Updated {{$repository->last_pushed_at->diffForHumans()}}</span>
    </div>
</div>
