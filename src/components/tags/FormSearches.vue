<script setup>
import {reactive} from "vue";

defineProps({
    searches: {
        type: Array,
        default: () => []
    }
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
        class="input-group shadow-sm search-box">

        <span class="input-group-text rounded-0 border-0 bg-white">
            <i class="bi bi-search searches-icon-font"></i>
        </span>

        <input
            v-if="search.type === 'date'"
            v-model="searchValues[search.id]"
            type="date"
            class="form-control border-0 rounded-0 shadow-none searches-box-font searches-box-date-color"
            @change="handleSearch(search)"
        />

        <input
            v-else
            v-model="searchValues[search.id]"
            type="text"
            class="form-control border-0 rounded-0 shadow-none searches-box-font"
            v-bind:placeholder="search.placeholder"
            @input="handleSearch(search)"
        />
    </div>
</template>

<style scoped>

.search-box {
    width: 248px;
    height: 42px;
}

.searches-box-font {
    font-family: "Poppins", serif !important;
    font-size: 12px !important;
    font-weight: 400 !important;
    color: #90A0B7;
}

.searches-box-font::placeholder {
    color: #90A0B7 !important;
    opacity: 1;
}

.searches-icon-font{
    color: #C2CFE0 !important;
    width: 20px !important;
    height: 20px !important;
    display: flex;
    justify-content: center;
    align-items: center;
    padding-left: 18px;
}
</style>