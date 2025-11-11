<template>
    <component
        :is="iconComponent"
        v-if="iconComponent"
        class="w-4 h-4 text-gray-700"
    />
</template>

<script>
import {
    Lock,
    Globe,
    GitFork,
    GitCommit,
    GitBranch,
    Clock,
    Telescope,
    Bell,
    Settings,
    Funnel,
    Search,
    HardDrive,
    Calendar,
    Users,
    TrendingUp,
    LogOut,
    Plus,
} from 'lucide-vue-next';

export default {
    name: 'Icons',

    props: {
        type: {
            type: String,
            required: true,
        },
    },

    computed: {
        iconComponent() {
            const icons = {
                lock: Lock,
                globe: Globe,
                gitfork: GitFork,
                gitcommit: GitCommit,
                gitbranch: GitBranch,
                clock: Clock,
                telescope: Telescope,
                bell: Bell,
                settings: Settings,
                funnel: Funnel,
                search: Search,
                harddrive: HardDrive,
                calendar: Calendar,
                users: Users,
                trendingup: TrendingUp,
                logout: LogOut,
                plus: Plus,
            };

            return icons[this.type.toLowerCase()] || null;
        },
    },
};
</script>
