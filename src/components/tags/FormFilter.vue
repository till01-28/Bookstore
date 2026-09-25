<script setup>
defineProps({
    showEntity: {
        type: Boolean,
        default: false
    },
    entityName: {
        type: String,
        required: true
    },
    searches: {
        type: Array,
        default: () => []
    },
    modelValue: {
        type: String,
        default: 'all'
    }
})

defineEmits(['update:modelValue'])
</script>

<template>
    <div
        v-if="showEntity"
        class="d-flex justify-content-start align-items-center"
    >
        <span>{{ entityName }}</span>

        <span class="d-inline-block custom-select">
            <select
                class="form-select border-0 rounded-0 shadow-none ps-1 font-filter"
                v-bind:value="modelValue"
                @change="$emit('update:modelValue', $event.target.value)"
            >
                <option value="all">
                    Hammasi
                </option>

                <option
                    v-for="search in searches"
                    v-bind:key="search.id"
                    v-bind:value="search.id"
                >
                    {{search.label}}
                </option>

            </select>
        </span>
    </div>
</template>

<style scoped>
.font-filter {
    font-family: 'Poppins', serif !important;
    font-weight: 400 !important;
    font-size: 12px !important;
    line-height: 100% !important;
    color: #109CF1 !important;
}

.form-select {
    background-image: none;
    appearance: none;
    -webkit-appearance: none;
}

.custom-select {
    position: relative;
    display: inline-block;
}

.custom-select::after {
    content: "";
    position: absolute;
    right: 28px;
    top: 44%;
    color: #C2CFE0 !important;

    border-left: 3px solid transparent;
    border-right: 3px solid transparent;
    border-top: 3px solid;

    transform: translateY(-25%);
    pointer-events: none;
}

</style>