<script setup>
import NavBar from "@/components/NavBar.vue";
import SearchBars from "@/components/SearchBars.vue";
import TableRow from "@/components/TableRow.vue";
import Modal from "@/components/Modal.vue";

const searches = [
    { placeholder: 'Mijozlarni qidirish' },
    { placeholder: 'Email qidirish' },
    { placeholder: 'Parol qidirish' },
    { placeholder: 'Ishlash joini qidirish'},
    { placeholder: "So'ngi faollikni qidirish" }
]

const thClientColumns = [
    'Mijozlar',
    'Email',
    'Parol',
    'Ishlash joyi',
    "So'ngi faollik",
    '',
    '',
]
</script>

<template>
    <NavBar button-name="Mijoz" modal-id="addClient"/>
    <div class="container-fluid">
        <SearchBars v-bind:searches = "searches" v-bind:show-entity="true" entity-name="Mijozlar:"/>
        <TableRow v-bind:th-columns="thClientColumns" edit-modal-id="editClient"/>
    </div>
    <Modal component-id="addClient" modal-name="Mijozni malumotlarini kiriting" modal-type="client"/>
    <Modal component-id="editClient" modal-name="Malumotlarni o'zgartiring" modal-type="client"/>
</template>

<style scoped>
</style>