<script setup>
import {reactive} from "vue";

defineProps({
    searches: {
        type: Array,
        default: () => []
    },
})

const emit = defineEmits(['search']);

const searchValues = reactive({});

let timeout;

function handleSearch(search) {
    clearTimeout(timeout);

    timeout = setTimeout(() => {

        emit('search', {
            field: search.id,
            value: searchValues[search.id] || ''
        })
    }, 500);
}
</script>

<template>
    <div
        v-for="search in searches"
        v-bind:key="search.id"
        class="input-group shadow-sm search-box"
    >

        <span
            class="input-group-text rounded-0 border-0 bg-white">
            <i class="bi bi-search ms-2"></i>
        </span>

        <input
            v-model="searchValues[search.id]"
            type="text"
            class="form-control border-0 rounded-0 shadow-none"
            v-bind:placeholder="search.placeholder"
            @input="handleSearch(search)"
        />
    </div>
</template>

<style scoped>

</style>