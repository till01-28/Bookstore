<script setup>
defineProps({
    text:{
        type:String,
        required: true
    },
    modalId: {
        type: String,
        required: true
    }
})

</script>

<template>
    <div class="modal fade" v-bind:id="modalId" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-success text-light">
                <div class="d-flex justify-content-around align-items-center m-1">
                    <i class="bi bi-check-circle fs-1"></i>
                    <h5 class="mt-2">{{text}}</h5>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>