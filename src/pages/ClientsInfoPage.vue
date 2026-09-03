<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useGetClients} from "@/stores/clients/getClients.js";
import {computed} from "vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import FormSelect from "@/components/tags/FormSelect.vue";
import {useFetchCompanies} from "@/stores/company/getCompanies.js";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";

useGetClients().getClients()
const clients = computed( () => useGetClients().clientState.clients)

useFetchCompanies().getCompanies()
const companies = computed(() => useFetchCompanies().companyState.companies)


const searches = [
    {
        id: 'ism',
        label: 'Mijoz Ismi',
        placeholder: 'Mijozlarni ismini qidirish'
    },
    {
        id: 'email',
        label: 'Email',
        placeholder: 'Email qidirish'
    },
    {
        id: 'password',
        label: 'Password',
        placeholder: 'Parol qidirish'
    },
    {
        id: 'company',
        label: 'Company',
        placeholder: 'Ishlash joini qidirish'
    },
    {
        id:'activity',
        label: 'So\'ngi faollik',
        placeholder: "So'ngi faollikni qidirish"
    }
]
const {selectedSearch, visibleSearches} = useSearchFilter(searches)

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
        <div class="container-fluid">
            <FormFilter
                v-model="selectedSearch"
                v-bind:searches="searches"
                v-bind:show-entity="true"
                entity-name="Mijozlar:"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches
                    v-bind:searches="visibleSearches"
                />
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle text-center" id="dataTable">
                    <FormTable v-bind:th-columns="thClientColumns"/>
                    <tbody class="table_dimensions">
                    <tr v-for="client in clients" v-bind:key="client.id">
                        <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table" alt="#">
                            {{client.name}}
                        </td>
                        <td>{{client.email}}</td>
                        <td>{{client.password}}</td>
                        <td>{{client.clientsCompanyName}}</td>
                        <td>{{client.lastActivityAt}}</td>
                        <td>
                            <FormEditPen edit-modal-id="editClient"/>
                        </td>
                        <td>
                           <FormDeleteTrash edit-modal-id="editClient"/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addClient" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title">Mijoz malumotlarini kiriting</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormSelect
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Ish joyi"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="file"
                                label-name="Rasm tanlang"
                                input-type="file"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Qo'shish"
                        data-bs-dismiss="modal"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editClient" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title">Malumotlarni o'zgartiring</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormSelect
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Ish joyi"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="file"
                                label-name="Rasm tanlang"
                                input-type="file"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Qo'shish"
                        data-bs-dismiss="modal"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
</style>