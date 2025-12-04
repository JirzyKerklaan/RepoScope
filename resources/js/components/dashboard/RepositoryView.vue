<template>
    <div v-if="repository" class="bg-slate-900 rounded-lg border border-slate-800 h-full max-h-[calc(100vh-175px)] overflow-scroll">
        <div class="p-6 border-b border-slate-800">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <Icon v-if="repository.private" type="lock" class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <Icon v-else type="globe" class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                    <div>
                        <h2 class="text-slate-100 text-2xl">{{repository.name}}</h2>
                    </div>
                </div>
                <Badge
                    variant="outline"
                    :class="[
                        '',
                        repository.private
                          ? 'bg-orange-500/20 text-orange-300 border-orange-500/50'
                          : 'bg-green-500/20 text-green-300 border-green-500/50'
                    ]"
                    >
                    {{repository.private ? 'Private' : 'Public'}}
                </Badge>
            </div>
            <div class="grid grid-cols-4 gap-4 mt-6">
                <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                    <div class="flex items-center gap-2 text-slate-400 mb-2">
                        <icon type="gitbranch" class="w-4 h-4"></icon>
                        <span class="text-sm">Branches</span>
                    </div>
                    <p class="text-slate-100 text-2xl">{{repository.branch_count}}</p>
                </section>

                <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                    <div class="flex items-center gap-2 text-slate-400 mb-2">
                        <icon type="gitfork" class="w-4 h-4"></icon>
                        <span class="text-sm">Pull requests</span>
                    </div>
                    <p class="text-slate-100 text-2xl">{{repository.pulls_count}}</p>
                </section>

                <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                    <div class="flex items-center gap-2 text-slate-400 mb-2">
                        <icon type="gitcommit" class="w-4 h-4"></icon>
                        <span class="text-sm">Commits</span>
                    </div>
                    <p class="text-slate-100 text-2xl">{{ totalCommits }}</p>
                </section>

                <section class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border bg-slate-800/50 border-slate-700 p-4">
                    <div class="flex items-center gap-2 text-slate-400 mb-2">
                        <icon type="harddrive" class="w-4 h-4"></icon>
                        <span class="text-sm">Size</span>
                    </div>
                    <p class="text-slate-100 text-2xl">{{repository.size}} MB</p>
                </section>
            </div>
            <div class="flex items-center gap-6 mt-4 text-sm text-slate-400">
                <div class="flex items-center gap-2">
                    <icon type="calendar" class="w-4 h-4 text-slate-400"></icon>
                    <span>Updated {{formattedLastPushedAt}}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full" :class="`bg-color-${repository.language.toLowerCase()}`"></span>
                    <span>{{repository.language}}</span>
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
                        <p class="text-slate-100 text-xl">{{repository.users.length}}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="bg-green-500/20 p-3 rounded-lg">
                        <icon type="trendingup" class="w-5 h-5 text-green-400"></icon>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Active Pull Requests</p>
                        <p class="text-slate-100 text-xl">{{repository.pulls_count}}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="bg-purple-500/20 p-3 rounded-lg">
                        <icon type="gitcommit" class="w-5 h-5 text-purple-400"></icon>
                    </div>
                    <div>
                        <p class="text-sm text-slate-400">Total Contributions</p>

                        <p class="text-slate-100 text-xl">{{totalCommits}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6 max-h-1/2 overflow-scroll" v-if="repository.users.length > 0">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-slate-100">Members with Access</h3>
                <div class="flex gap-4">
                    <Badge variant="outline" class="bg-slate-800 border-slate-700 text-slate-300">
                        {{repository.users.length}} members
                    </Badge>
                    <a :href="repository.html_url + '/settings/access'" target="_blank">
                        <Badge variant="outline" class="bg-slate-800 border-slate-700 text-slate-300 hover:bg-slate-700 transition-all">
                            <icon type="plus" class="h-4 w-4 text-slate-300"></icon>
                            Add member
                        </Badge>
                    </a>
                </div>
            </div>

            <div>
                <div class="space-y-2">
                    <div class="grid grid-cols-12 gap-4 px-4 pb-3 text-xs text-slate-500 border-b border-slate-800">
                        <div class="col-span-8">Member</div>
                        <div class="col-span-2">Permission</div>
                        <div class="col-span-2 text-center">Commits</div>
                    </div>

                    <div v-for="member in repository.users" class="grid grid-cols-12 gap-4 items-center p-4 rounded-lg hover:bg-slate-800/50 transition-colors group">
                        <div class="col-span-8 flex items-center gap-3">
                            <img
                                :src="member.avatar"
                                alt="User"
                                class="w-10 h-10 rounded-full ring-2 ring-slate-700"
                            />
                            <div class="min-w-0 flex-1">
                                <p class="text-slate-100 truncate">{{ member.name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{member.email}}</p>
                            </div>
                        </div>

                        <div class="col-span-2">
                            <Badge
                                variant="outline"
                                :class="getMemberRoleColor(member.pivot.role)"
                            >
                                {{ member.pivot.role }}
                            </Badge>
                        </div>

                        <div class="col-span-2 text-center">
                            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-md bg-slate-800/50">
                                <Icon type="gitcommit" class="w-3.5 h-3.5 text-slate-400"/>
                                <span class="text-slate-100">{{member.pivot.commit_count}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Icon from "../../icons/Icons.vue";
import Badge from "../Badge.vue";
import {computed} from "vue";
import dayjs from "dayjs";

const props = defineProps({
    repository: {
        type: Object,
        required: true
    }
});

const getMemberRoleColor = (role) => {
    switch (role.toLowerCase()) {
        case "admin":
            return "text-purple-400 bg-purple-500/20";
        case "write":
            return "text-indigo-400 bg-indigo-500/20";
        case "read":
            return "text-orange-300 bg-orange-500/20";
        case "watcher":
            return "text-green-400 bg-green-500/20";
    }
}

const totalCommits = computed(() => props.repository.commits_count || 0);

const formattedLastPushedAt = computed(() =>
    props.repository.last_pushed_at ? dayjs(props.repository.last_pushed_at).fromNow() : "N/A"
);
</script>
