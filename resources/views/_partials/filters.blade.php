<form class="flex items-center gap-4" method="get" action="{{route('dashboard')}}">
    <div class="flex-1 relative">
        <icon type="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-500 z-5" ></icon>
        <x-input type="text" id="filter" name="filter" placeholder="Search repositories..." value="{{ $filter ?? '' }}" />
    </div>
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
        :options="collect(['all' => 'All Languages'])
                ->merge(array_combine($allLanguages, $allLanguages))
                ->toArray()"
        :value="$selectedLanguage"
    />
    <x-button variant="submit" class="text-white hover:text-slate-100 bg-indigo-600 hover:bg-indigo-800">
        <icon type="search" class="aspect-square h-full text-slate-400" />
    </x-button>
</form>
