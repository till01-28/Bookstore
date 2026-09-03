<script setup>
defineProps({
    searches: {
        type: Array,
        default: () => []
    },
})
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
            type="text" class="form-control border-0 rounded-0 shadow-none"
               v-bind:placeholder="search.placeholder"
        />
    </div>
</template>

<style scoped>

</style>