<template>
    <div
        @click="$emit('select', repository)"
        :class="[
      'w-full text-left p-4 rounded-lg mb-2 transition-all cursor-pointer',
      active
        ? 'bg-indigo-600/20 border border-indigo-500/50'
        : 'bg-slate-800/50 border border-slate-700/50 hover:bg-slate-800 hover:border-slate-700'
    ]"
    >
        <div class="flex items-start justify-between mb-2">
            <div class="flex items-center gap-2 flex-1 min-w-0">
                <Icon v-if="repository.private" type="lock" class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                <Icon v-else type="globe" class="w-4 h-4 text-slate-400 flex-shrink-0"/>
                <h3 class="text-indigo-100">
                    {{ repository.name}}
                </h3>
            </div>
            <Badge
                variant="outline"
                :class="[
                  'ml-2 flex-shrink-0',
                  active
                    ? 'bg-indigo-500/20 border-indigo-400 text-indigo-200'
                    : 'bg-slate-700 border-slate-600 text-slate-300'
                ]"
            >
                {{ repository.language }}
            </Badge>
        </div>

        <p class="text-sm text-slate-400 mb-3 line-clamp-1 h-[1.25rem]">
            {{ repository.description}}
        </p>

        <div class="flex items-center gap-4 text-xs text-slate-500">
            <div class="flex items-center gap-1">
                <Icon type="gitbranch" class="w-4 h-4"/>
                <span>{{ repository.branch_count }}</span>
            </div>
            <div class="flex items-center gap-1">
                <Icon type="gitfork" class="w-4 h-4"/>
                <span>{{ repository.pulls_count }}</span>
            </div>
            <div class="flex items-center gap-1">
                <Icon type="gitcommit" class="w-4 h-4"/>
                <span>{{totalCommits}}</span>
            </div>
            <div class="flex items-center gap-1 ml-auto">
                <span class="text-indigo-300 text-slate-400">
                    {{ repository.users.length }} {{ repository.users.length === 1 ? 'member' : 'members' }}
                </span>
            </div>
        </div>

        <div class="flex items-center gap-1 text-xs text-slate-500 mt-2">
            <Icon type="clock"/>
            <span>Updated {{ formattedLastPushedAt }}</span>
        </div>
    </div>
</template>

<script setup>
import Icon from "../../icons/Icons.vue";
import Badge from "../../components/Badge.vue";
import { computed } from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";

dayjs.extend(relativeTime);

const props = defineProps({
    repository: {
        type: Object,
        required: true
    },
    active: {
        type: Boolean,
        required: true
    }
});


const totalCommits = computed(() => props.repository.commits_count || 0);

const formattedLastPushedAt = computed(() =>
    props.repository.last_pushed_at ? dayjs(props.repository.last_pushed_at).fromNow() : "N/A"
);
</script>
