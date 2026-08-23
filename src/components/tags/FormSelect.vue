<script setup>

defineProps({
    labelName: {
        type: String,
        required: true,
    },
    propsId: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        default: () => []
    },
    required:{
        type: Boolean,
        default: false
    },
    placeholder: {
        type: String,
        default: "Ish joini tanlang"
    }
})
</script>

<template>
    <div class="mt-3">
        <label v-bind:for="propsId" class="form-label">{{ labelName }}
            <i v-if="required" class="bi bi-asterisk asterisk"></i>
        </label>

        <select v-bind:id="propsId" class="form-select text-secondary">
            <option value="" disabled selected> {{ placeholder }}</option>
            <option selected v-for="option in options" v-bind:key="option.id" v-bind:value="option.id">
                {{ option.name}}
            </option>
        </select>
    </div>
</template>

<style scoped>

</style>