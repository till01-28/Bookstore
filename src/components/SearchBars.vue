<script setup>
defineProps({
    showEntity: {
        type: Boolean,
        default: false
    },
    searches: {
        type: Array,
        default: () => []
    },
    entityName: {
        type: String,
        required: true
    }
})
</script>

<template>
    <div class="container-fluid">
        <div v-if="showEntity" class="d-flex justify-content-start align-items-center">
            <span>{{entityName}}</span>
            <span class="d-inline-block">
                    <select class="form-select border-0 rounded-0 shadow-none ps-1">
                        <option selected>Hammasi</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option  value="3">Three</option>
                    </select>
                </span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
            <div
                v-for="(search, index) in searches" v-bind:key="index"
                class="input-group shadow-sm search-box">

                <span
                    class="input-group-text rounded-0 border-0 bg-white">
                    <i class="bi bi-search ms-2"></i>
                </span>

                <input
                    type="text"
                    class="form-control border-0 rounded-0 shadow-none"
                    v-bind:placeholder="search.placeholder"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>