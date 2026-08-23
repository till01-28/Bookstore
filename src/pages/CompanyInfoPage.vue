<script setup>
import NavBar from "@/components/NavBar.vue";
import SearchBars from "@/components/SearchBars.vue";
import TableRow from "@/components/TableRow.vue";
import Modal from "@/components/Modal.vue";

const searches = [
    {placeholder: 'Kompaniya qidirish'},
    {placeholder: 'Email qidirish'},
    {placeholder: 'Parol qidirish'},
    {placeholder: 'So\'ngi faollikni qidirish'}
]
const thCompanyColumns = [
    'Kompaniyalar',
    'Email',
    'Parol',
    "So'ngi faollik",
    '',
    '',
]
</script>

<template>
    <NavBar button-name="Kompaniya" modal-id="addCompany"/>
    <div class="container-fluid">
        <SearchBars v-bind:searches="searches" v-bind:show-entity="true" entity-name="Kompaniyalar:"/>
        <TableRow v-bind:th-columns="thCompanyColumns" edit-modal-id="editCompany"/>
    </div>
    <Modal component-id="addCompany" modal-name="Kompaniya malumotlarini kiriting" modal-type="company"/>
    <Modal component-id="editCompany" modal-name="Malumotlarni o'zgartiring" modal-type="company"/>
</template>

<style scoped>

</style>