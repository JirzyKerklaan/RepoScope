<template>
    <div class="grid grid-cols-12 gap-6 mt-6">
        <div class="col-span-5">
            <div class="bg-slate-900 rounded-lg border border-slate-800 max-h-[calc(100vh-175px)] overflow-scroll">
                <div class="p-4 border-b border-slate-800">
                    <h2 class="text-slate-100">Repositories</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ repositories.length }} repositories</p>
                </div>

                <section>
                    <div class="p-2 pb-0">
                        <RepositoryList
                            :repositories="repositories"
                            :selectRepository="selectRepository"
                            :selected="selected"
                        />
                    </div>
                </section>
            </div>
        </div>

        <div class="col-span-7">
            <RepositoryView :repository="selected" />
        </div>
    </div>

    <CollaboratorPopup :isOpen="isOpen" :onClose="onClose" />
</template>

<script>
import RepositoryList from "./RepositoryList.vue";
import RepositoryView from "./RepositoryView.vue";
import CollaboratorPopup from "./collaborators/CollaboratorPopup.vue";

export default {
    components: {CollaboratorPopup, RepositoryList, RepositoryView },

    props: {
        repositories: {
            type: Array,
            required: true
        }
    },

    data() {
        return {
            isOpen: true,
            selected: this.repositories[0]
        }
    },

    methods: {
        selectRepository(repo) {
            this.selected = repo
        },
        onClose() {
            this.isOpen = false;
        }
    }
}
</script>
