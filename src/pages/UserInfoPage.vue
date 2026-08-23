<script setup>
import NavBar from "@/components/NavBar.vue";
import SearchBars from "@/components/SearchBars.vue";
import TableRow from "@/components/TableRow.vue";
import Modal from "@/components/Modal.vue";

const searches = [
    {placeholder: 'Foydalanuvchini qidirish'},
    {placeholder: 'Email qidirish'},
    {placeholder: 'Parol qidirish'},
    {placeholder: 'So\'ngi faollikni qidirish'}
]

const thUserColumns = [
    'Foydalanuvchilar',
    'Email',
    'Parol',
    "So'ngi faollik",
    '',
    '',
]
</script>

<template>
    <NavBar button-name="Foydalanuvchi" modal-id="addUser"/>
    <div class="container-fluid">
        <SearchBars v-bind:searches="searches" v-bind:show-entity="true" entity-name="Foydalanuvchilar:"/>
        <TableRow v-bind:th-columns="thUserColumns" edit-modal-id="editUser"/>
    </div>
    <Modal component-id="addUser" modal-name="Foydalanuvchi malumotlarini kiriting" modal-type="user"/>
    <Modal component-id="editUser" modal-name="Malumotlarni o'zgartiring" modal-type="user"/>
</template>

<style scoped>

</style>