<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 bg-black/70 z-40 flex items-center justify-center"
        @click="handleCancel"
    />

    <div
        v-if="isOpen"
        class="fixed top-[10%] left-[10%] w-[80vw] h-[80vh] bg-slate-900 border border-slate-800 rounded-lg shadow-2xl z-50 flex flex-col"
        @click.stop
    >
        <div class="flex items-center justify-between p-6 border-b border-slate-800 flex-shrink-0">
            <div>
                <h2 class="text-xl text-slate-100">Frequent Members</h2>
                <p class="text-sm text-slate-400 mt-1">
                    Map GitHub usernames to display names for easier identification
                </p>
            </div>
        </div>

        <div class="flex-1 grid grid-cols-2 gap-6 p-6 overflow-hidden">
            <div class="flex flex-col border border-slate-800 rounded-lg bg-slate-950/50 overflow-hidden">
                <div class="p-4 border-b border-slate-800 bg-slate-900/50">
                    <h3 class="text-slate-100">Saved Members ({{ frequentMembers.length }})</h3>
                </div>
                <div class="flex-1 overflow-y-auto p-4 space-y-2">
                    <div
                        v-if="frequentMembers.length === 0"
                        class="flex items-center justify-center h-full text-slate-500"
                    >
                        No frequent members added yet
                    </div>
                    <div
                        v-for="member in frequentMembers"
                        :key="member.id"
                        class="flex items-center justify-between p-3 bg-slate-900 border border-slate-800 rounded-lg hover:border-slate-700 transition-colors group"
                    >
                        <div class="flex-1 min-w-0">
                            <p class="text-slate-100 truncate">{{ member.displayName }}</p>
                            <p class="text-sm text-slate-400 truncate">@{{ member.githubUsername }}</p>
                        </div>
                        <button
                            size="icon"
                            class="btn danger size-9 rounded-md hover:bg-slate-800 hover:text-red-400"
                            @click="handleDelete(member.id)"
                        >
                            <Icons type="trash2" class="w-4 h-4" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="flex flex-col border border-slate-800 rounded-lg bg-slate-950/50 overflow-hidden">
                <div class="p-4 border-b border-slate-800 bg-slate-900/50 flex items-center gap-2">
                    <Icons type="plus" class="w-5 h-5 text-indigo-400" />
                    <h3 class="text-slate-100">Add New Member</h3>
                </div>
                <div class="flex-1 p-6 space-y-6 overflow-y-auto">
                    <div>
                        <label class="block text-sm text-slate-400 mb-2">
                            Step 1: GitHub Username
                        </label>
                        <input
                            type="text"
                            v-model="githubUsername"
                            :disabled="step === 'name'"
                            placeholder="e.g., octocat"
                            class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            @keydown.enter="step === 'username' && githubUsername.trim() && handleNext()"
                        />
                        <p v-if="step === 'username'" class="text-xs text-slate-500 mt-2">
                            Enter the GitHub username you want to map
                        </p>
                    </div>

                    <div v-if="step === 'name'">
                        <label class="block text-sm text-slate-400 mb-2">
                            Step 2: Display Name
                        </label>
                        <input
                            type="text"
                            v-model="displayName"
                            placeholder="e.g., John Doe"
                            class="w-full px-4 py-3 bg-slate-800 border border-slate-700 rounded-lg text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            @keydown.enter="displayName.trim() && handleSave()"
                        />
                        <p class="text-xs text-slate-500 mt-2">
                            Enter a friendly name for <span class="text-indigo-400">@{{ githubUsername }}</span>
                        </p>
                    </div>

                    <div class="flex gap-3 pt-4">
                        <button
                            v-if="step === 'name'"
                            class="btn hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 py-2 flex-1 text-slate-400 bg-slate-700 hover:text-slate-100 hover:bg-slate-800"
                            @click="goBack"
                        >
                            Back
                        </button>

                        <button
                            v-if="step === 'username'"
                            class="btn hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 py-2 flex-1 bg-indigo-600 hover:bg-indigo-700 text-white"
                            :disabled="!githubUsername.trim()"
                            @click="handleNext"
                        >
                            Next
                        </button>

                        <button
                            v-else
                            class="btn hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50 py-2 flex-1 bg-indigo-600 hover:bg-indigo-700 text-white"
                            @click="handleSave"
                        >
                            Add Member
                        </button>
                    </div>

                    <div class="mt-auto pt-6">
                        <div class="bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                            <p class="text-xs text-slate-400 leading-relaxed">
                                <span class="text-slate-300">💡 Tip:</span> Frequent members help you quickly identify team members by mapping their GitHub usernames to familiar names throughout the application.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 p-6 border-t border-slate-800 flex-shrink-0">
            <button
                class="btn text-primary underline-offset-4 hover:underline text-slate-400 hover:text-slate-100"
                @click="handleCancel"
            >
                Close
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import Icons from "../../../icons/Icons.vue";
import {onMounted} from "vue";

const props = defineProps({
    isOpen: Boolean,
    onClose: Function
});

const processing = ref(false);
const step = ref('username');
const githubUsername = ref('');
const displayName = ref('');
const frequentUser = ref({});
const emit = defineEmits(["close"]);

const frequentMembers = ref([]);

function handleNext() {
    processing.value = true
    if (githubUsername.value.trim()) {
        axios.get('/members/' + githubUsername.value)
            .then((response) => {
                displayName.value = response.data.display_name;
                frequentUser.value = response.data
                step.value = 'name';
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                processing.value = false
            })
    }
}

function handleSave() {
    if (displayName.value.trim()) {
        processing.value = true
        frequentUser.value.display_name = displayName.value;
        axios.put('/members', { ...frequentUser.value })
            .then((response) => {
                console.log(response.data);
                frequentUser.value = [];
                githubUsername.value = '';
                displayName.value = '';
                step.value = 'username';
            }).catch((error) => {
                console.log(error);
            }).finally(() => {
                processing.value = false
        })
    }
}

function handleDelete(id: string) {
    frequentMembers.value = frequentMembers.value.filter(m => m.id !== id);
}

function goBack() {
    step.value = 'username';
    displayName.value = '';
}

function handleCancel() {
    githubUsername.value = '';
    displayName.value = '';
    step.value = 'username';
    emit('close');

    props.onClose?.();
}
</script>
