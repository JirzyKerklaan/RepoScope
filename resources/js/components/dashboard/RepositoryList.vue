<template>
    <RepositoryListItem
        v-for="repository in repositories"
        :key="repository.id"
        :repository="repository"
        :active="repository.id === selected?.id"
        @select="handleSelect"
    />
</template>

<script setup>
import RepositoryListItem from "./RepositoryListItem.vue";

const props = defineProps({
    repositories: {
        type: Array,
        required: true
    },
    selectRepository: {
        type: Function
    },
    selected: {
        type: Object,
        default: null
    }
});

function handleSelect(repository) {
    props.selectRepository?.(repository);
}
</script>
