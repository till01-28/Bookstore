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
import {useSearchCompanies} from "@/stores/company/useSearchCompanies.js";
import {format, isToday, differenceInMinutes, differenceInHours} from 'date-fns';
import { uz } from 'date-fns/locale';

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
        id: 'lastActivityAt',
        label: 'Activity',
        type: 'date',
    }
]
//**********************************************************************************************************************
const {selectedSearch, visibleSearches} = useSearchFilter(searches)

const searchCompany = useSearchCompanies();

function searchCompanyInfo(searchParams) {
    searchCompany.searchCompanies(
        searchParams, '/companies',
    )
        .then((res) => {
            useFetchCompanies().companyState.companies = [...res.data.member].sort((a, b) => b.id - a.id);
        })
        .catch(() => {
            console.log("ERROR, search is Failed")
        })
}

//**********************************************************************************************************************

// Table modifications

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

    const time = format(activityDate, 'HH:mm');

    if (isToday(activityDate)) {
        const minutes = differenceInMinutes(now, activityDate);
        const hours = differenceInHours(now, activityDate);

        if (minutes < 1) {
            return `Hozirgina ${time}`;
        }

        if (minutes < 60) {
            return `${minutes} daqiqa oldin ${time}`;
        }

        return `${hours} soat oldin ${time}`;
    }

    return format(activityDate, 'dd MMM, yyyy HH:mm');
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
                class="company-filter"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches
                    v-bind:searches="visibleSearches"
                    @search="searchCompanyInfo"
                />
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle" id="dataTable">
                    <FormTable v-bind:th-columns="thCompanyColumns"/>
                    <tbody>
                    <tr v-for="company in companies" v-bind:key="company.id" class="del-edit-icons">
                        <td class="company-tbNames-font">
                            <img
                                v-if="company.image"
                                v-bind:src="host + company.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{company.name}}
                        </td>
                        <td class="company-tbCol-font">{{company.email}}</td>
                        <td class="company-tbCol-font">{{company.password}}</td>
                        <td class="company-tbCol-font">{{formatLastActivity(company.lastActivityAt)}}</td>
                        <td class="pen">
                            <FormEditPen
                                edit-modal-id="editCompany"
                                @click="select(company)"
                            />
                        </td>
                        <td class="trashCan">
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
                <div class="modal-header text-center">
                    <h5 class="modal-title modal-font-name">Kompaniya malumotlarini kiriting</h5>
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
                        class="button-company-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-company-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editCompany" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title modal-font-name">Malumotlarni o'zgartiring</h5>
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
                        class="button-company-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-company-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteCompany" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="company-del-name">Rostan ham o'chirilsinmi ?</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Ha"
                            class="company-del-btn company-del-red me-4 del-icon-pos"
                            @click="remove(selectedCompanyId)"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"

                        />
                        <FormButton
                            type="button"
                            text="Yo'q"
                            class="company-del-btn company-del-green del-icon-pos"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />

                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNotificationModal modal-id="companyAdded" text="Kompaniya muaffaqiyatli qushildi !"/>
</template>

<style scoped>
.company-tbCol-font {
    font-family: "Poppins",serif !important;
    color: #707683 !important;
    font-size: 13px;
    font-weight: 400 !important;
    line-height: 100% !important;
}
.company-tbNames-font {
    font-family: "Poppins", serif !important;
    color: #323C47 !important;
    font-size: 15px;
    font-weight: 500 !important;
    line-height: 100% !important;
}
.company-filter {
    font-family: "Poppins", sans-serif !important;
    color: #707683 !important;
    font-size: 12px !important;
    font-weight: 400 !important;
    line-height: 100% !important;
    padding: 10px 0 10px 0 !important;
}
.modal-font-name {
    font-family: "Poppins",serif !important;
    font-weight: 600 !important;
    line-height: 100% !important;
    font-size: 13px !important;
}
.button-company-edit{
    width: 108px !important;
    height: 29px !important;
    line-height: 24px !important;
}

.company-del-btn{
    width: 94px;
    height: 30px;
    border-radius: 2px;
}
.company-del-red{
    background-color: #F7685B;
}
.company-del-green{
    background-color: #34D47E;
}
.company-del-name{
    font-family: "Poppins", sans-serif !important;
    color: #000000;
    font-size: 15px;
    font-weight: 400;
    line-height: 100%;
}
</style>