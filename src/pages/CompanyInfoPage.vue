<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import {useFetchCompanies} from "@/stores/company/getCompanies.js";
import {computed} from "vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";

useFetchCompanies().getCompanies()
const companies = computed(() => useFetchCompanies().companyState.companies)

const searches = [
    {
        id: 'name',
        label: 'Nomi',
        placeholder: 'Kompaniya nomini qidirish'
    },
    {
        id: 'email',
        label:'Email',
        placeholder: 'Email qidirish'
    },
    {
        id: 'password',
        label: 'Parol',
        placeholder: 'Parol qidirish'
    },
    {
        id: 'activity',
        label: 'So\'ngi faollik',
        placeholder: 'So\'ngi faollikni qidirish'
    }
]

const {selectedSearch, visibleSearches} = useSearchFilter(searches)

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
        <div class="container-fluid">
            <FormFilter
                v-model="selectedSearch"
                v-bind:show-entity="true"
                v-bind:searches="searches"
                entity-name="Kompaniyalar:"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches v-bind:searches="visibleSearches"/>
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle text-center" id="dataTable">
                    <FormTable v-bind:th-columns="thCompanyColumns"/>
                    <tbody class="table_dimensions">
                    <tr v-for="company in companies" v-bind:key="company.id">
                        <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table" alt="#">
                            {{company.name}}
                        </td>
                        <td>{{company.email}}</td>
                        <td>{{company.password}}</td>
                        <td>{{company.lastActivityAt}}</td>
                        <td>
                            <FormEditPen edit-modal-id="editCompany"/>
                        </td>
                        <td>
                           <FormDeleteTrash/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addCompany" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title">Kompaniya malumotlarini kiriting</h5>
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
                            <FormInput
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="12345678"
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
    <div class="modal fade" id="editCompany" tabindex="-1">
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
                            <FormInput
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="12345678"
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