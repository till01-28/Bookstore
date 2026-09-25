<script setup>
import {useToggleSidebar} from "@/stores/sidebar/toggleSidebar.js";
import FormButton from "@/components/tags/FormButton.vue";
const toggle = useToggleSidebar();

defineProps({
    buttonName: {
        type: String,
        required: true,
    },

    modalId: {
        type: String,
        required: true,
    }
})
</script>

<template>
    <nav class="navbar navbar-expand navbar-dark bg-white navbar_dimensions me-4 ms-4">
            <button
                class="btn btn-outline-secondary d-md-none ms-3"
                @click="toggle.toggleSidebar()"
            >
                <i class="bi bi-list"></i>
            </button>

            <FormButton
                class="ms-auto me-3"
                type="button"
                data-bs-toggle="modal"
                v-bind:data-bs-target="`#${modalId}`"
                v-bind:text="`${buttonName} qo'shish`"
            />
    </nav>
</template>

<style scoped>
.navbar_dimensions {
    height: 61px;
}
</style>