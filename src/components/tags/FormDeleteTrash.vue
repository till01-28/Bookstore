<script setup>
defineProps({
    editModalId:{
        type: String,
        required: true,
    }
})

</script>

<template>
    <i
        class="icon-link icon-link-hover link-danger link-underline-danger bi bi-trash-fill"
        data-bs-toggle="modal"
        v-bind:data-bs-target="`#${editModalId}`"
    >
    </i>
</template>

<style scoped>

</style>