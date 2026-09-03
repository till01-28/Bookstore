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

        <span class="d-inline-block">
            <select
                class="form-select border-0 rounded-0 shadow-none ps-1"
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

</style>