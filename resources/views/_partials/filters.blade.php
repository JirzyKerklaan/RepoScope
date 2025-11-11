<form class="flex items-center gap-4" method="get" action="{{route('home')}}">
    <div class="flex-1 relative">
        <icon type="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 z-5" ></icon>
        <x-input type="text" id="filter" name="filter" placeholder="Search repositories..." value="{{ $filter ?? '' }}" />
    </div>
    <icon type="funnel" className="w-4 h-4 text-slate-400"></icon>
    <x-select
        name="private"
        :options="[
            'all' => 'View all',
            true => 'Private',
            false => 'Public',
        ]"
        value="{{ $private ?? '' }}"
        selected="all"
    />
    <x-select
        name="language"
        :options="[
        'all' => 'All Languages',
    ]"
        selected="all"
    />
</form>
