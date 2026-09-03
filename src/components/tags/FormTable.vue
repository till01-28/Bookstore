<script setup>

defineProps({
    thColumns: {
        type: Array,
        default: () => []
    },
    tableRows: {
        type: Array,
        default: () => []
    }
})
</script>

<template>
    <thead>
    <tr>
        <th v-for="(column, index) in thColumns" v-bind:key="index">
            {{column}}
        </th>
    </tr>
    </thead>
</template>

<style scoped>

</style>