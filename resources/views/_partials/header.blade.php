<header class="bg-slate-900 border-b border-slate-800">
    <div class="max-w-[1800px] mx-auto px-8 py-4 flex items-center justify-between">
        <a href="{{route('dashboard')}}" class="flex items-center gap-4">
            <div class="bg-indigo-600 p-2.5 rounded-lg">
                <icon type="telescope" class="w-6 h-6 text-white" />
            </div>
            <div>
                <h1 class="text-slate-100">RepoScope</h1>
                <p class="text-slate-400 text-sm">
                    {{count($repositories)}} repositories
                </p>
            </div>
        </a>

        <div class="flex items-center gap-0">
            <x-button
                class="text-slate-400 hover:text-slate-100 hover:bg-slate-800"
                onclick="window.dispatchEvent(new Event('open-frequent-members'))"
            >
                <icon type="list" class="w-5 h-5 text-slate-400"></icon>
                <span>Frequent members</span>
            </x-button>
            <div class="flex items-center gap-3 pl-4 ml-2 border-l border-slate-800">
                <img
                    src="{{auth()->user()->avatar}}"
                    alt="User"
                    class="w-9 h-9 rounded-full ring-2 ring-slate-700"
                />
                <div>
                    <p class="text-sm text-slate-100">{{auth()->user()->name}}</p>
                    <p class="text-xs text-slate-500">{{auth()->user()->email}}</p>
                </div>
                <x-button
                    variant="link"
                    href="{{route('logout')}}"
                    size="icon"
                    class="text-slate-400! hover:text-red-400! hover:bg-slate-800! ml-2!"
                >
                    <icon type="logout" class="w-5 h-5 text-slate-400" />
                </x-button>
            </div>
        </div>
    </div>
</header>
