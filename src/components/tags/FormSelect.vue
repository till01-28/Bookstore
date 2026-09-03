<script setup>

import {useFetchCompanies} from "@/stores/company/getCompanies.js";

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
    }

})

</script>

<template>
    <div class="mt-3">
        <label v-bind:for="propsId" class="form-label">{{ labelName }}
            <i v-if="required" class="bi bi-asterisk asterisk"></i>
        </label>

        <select v-bind:id="propsId" class="form-select text-dark">
            <option
                v-for="option in options"
                v-bind:key="option.id"
                v-bind:value="option.id">
                {{option.name}}
            </option>
        </select>
    </div>
</template>

<style scoped>

</style>