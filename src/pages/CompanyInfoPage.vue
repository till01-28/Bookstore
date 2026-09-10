<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import {useFetchCompanies} from "@/stores/company/getCompanies.js";
import {computed, reactive, ref} from "vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";
import {useAddFile} from "@/stores/mediaObject/addFile.js";
import {useImageFile} from "@/stores/addFile/imageFile.js";
import {useCreateCompany} from "@/stores/company/postCompanies.js";
import {useRouter} from "vue-router";
import {useChangeCompany} from "@/stores/company/changeCompanies.js";
import {useDeleteCompanies} from "@/stores/company/deleteCompanies.js";
import {Modal} from "bootstrap";
import FormNotificationModal from "@/components/tags/FormNotificationModal.vue";

const host = import.meta.env.VITE_API_DOMEN
useFetchCompanies().getCompanies()
const companies = computed(() => useFetchCompanies().companyState.companies)

//**********************************************************************************************************************
let isLoading = ref(false);
const router = useRouter();
let companyAdd = reactive({
    name: '',
    email: '',
    password: '',
})

function showNotification() {
    const modalElement = document.getElementById('companyAdded');
    const modalInstance = new Modal(modalElement);

    modalInstance.show();

    setTimeout(() => {
        modalInstance.hide();
    }, 3000);

}
const {selectImage, file} = useImageFile()

function create() {
    useAddFile().addFile(file.value)
        .then((res) => {
            companyAdd.image = res.data['@id'];
            return useCreateCompany().createCompany(companyAdd)
        })
        .then(() => {
            router.push("/company-info")
            useFetchCompanies().getCompanies()

            companyAdd.name = '';
            companyAdd.email = '';
            companyAdd.password = '';

            showNotification();
        })
}

//**********************************************************************************************************************
let companyEdit = reactive({
    id: '',
    name: '',
    email: '',
    password: ''
})

function select(company) {
    companyEdit.id = company.id;
    companyEdit.name = company.name;
    companyEdit.email = company.email;
    companyEdit.password = company.password;
}

function change() {
    useChangeCompany().changeCompany(
        companyEdit.id, {
            name: companyEdit.name,
            email: companyEdit.email,
            password: companyEdit.password
        })
        .then(() => {
            router.push("/company-info")
            useFetchCompanies().getCompanies()
        })
}

//**********************************************************************************************************************
const selectedCompanyId = ref(null);

function confirmDeleteCompany(id) {
    selectedCompanyId.value = id;
}
function remove(id) {
    useDeleteCompanies().deleteCompany(id)
        .then(() => {
            useFetchCompanies().getCompanies()
        })
}

//**********************************************************************************************************************
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
//**********************************************************************************************************************
const {selectedSearch, visibleSearches} = useSearchFilter(searches)

const thCompanyColumns = [
    'Kompaniyalar',
    'Email',
    'Parol',
    "So'ngi faollik",
    '',
    '',
]

function formatLastActivity(date) {
    if (!date) {
        return 'Hech qachon';
    }

    const activityDate = new Date(date);
    const now = new Date();

    const diff = now - activityDate;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor( days / 30);

    if (seconds < 60) {
        return 'Hozirgina';
    }

    if (minutes < 60) {
        return `${minutes} daqiqa oldin`;
    }

    if (hours < 24) {
        return `${hours} soat oldin`;
    }

    if (days < 30) {
        return `${days} kun oldin`;
    }

    if (months < 12) {
        return `${months} oy oldin`;
    }

    return activityDate.toLocaleDateString('uz-UZ', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    });
}
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
                <table class="table table-hover align-middle" id="dataTable">
                    <FormTable v-bind:th-columns="thCompanyColumns"/>
                    <tbody class="table_dimensions">
                    <tr v-for="company in companies" v-bind:key="company.id">
                        <td>
                            <img
                                v-if="company.image"
                                v-bind:src="host + company.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{company.name}}
                        </td>
                        <td>{{company.email}}</td>
                        <td>{{company.password.substring(7,20)}}</td>
                        <td>{{formatLastActivity(company.lastActivityAt)}}</td>
                        <td>
                            <FormEditPen
                                edit-modal-id="editCompany"
                                @click="select(company)"
                            />
                        </td>
                        <td>
                           <FormDeleteTrash
                               @click="confirmDeleteCompany(company.id)"
                               data-bs-target="#confirmDeleteCompany"
                               data-bs-toggle="modal"
                           />
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
                                v-model="companyAdd.name"
                                props-id="name"
                                label-name="To'liq Nomi"
                                input-type="name"
                                placeholder="Kadirov Dev Academy"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="companyAdd.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="kadirovdev@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="companyAdd.password"
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="********"
                                v-bind:required="true"
                            />
                            <FormInput
                                @change="selectImage($event)"
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
                        v-bind:loading="isLoading"
                        @click="create"
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
                <div class="modal-header">
                    <h5 class="modal-title ms-3">Malumotlarni o'zgartiring</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="companyEdit.name"
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="companyEdit.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="companyEdit.password"
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Qo'shish"
                        data-bs-dismiss="modal"
                        @click="change()"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteCompany" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="h5">Rostan ham o'chirilsinmi ?</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Ha"
                            class="btn btn-danger rounded-0 px-3 mx-3"
                            @click="remove(selectedCompanyId)"
                            data-bs-dismiss="modal"/>
                        <FormButton
                            type="button"
                            text="Yo'q"
                            class="btn btn-success rounded-0 px-2"
                            data-bs-dismiss="modal"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNotificationModal modal-id="companyAdded" text="Kompaniya muaffaqiyatli qushildi !"/>
</template>

<style scoped>

</style>