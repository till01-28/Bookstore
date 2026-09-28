<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useGetClients} from "@/stores/clients/getClients.js";
import {computed, reactive, ref} from "vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import FormSelect from "@/components/tags/FormSelect.vue";
import {useFetchCompanies} from "@/stores/company/getCompanies.js";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";
import {useImageFile} from "@/stores/addFile/imageFile.js";
import {useAddFile} from "@/stores/mediaObject/addFile.js";
import {useCreateClients} from "@/stores/clients/postClients.js";
import FormNotificationModal from "@/components/tags/FormNotificationModal.vue";
import {Modal} from "bootstrap";
import {useChangeClients} from "@/stores/clients/changeClients.js";
import {useDeleteClient} from "@/stores/clients/deleteClients.js";
import {useSearchClients} from "@/stores/clients/useSearchClients.js";
import {format, isToday, differenceInMinutes, differenceInHours} from 'date-fns';
import { uz } from 'date-fns/locale';

const host = import.meta.env.VITE_API_DOMEN
useGetClients().getClients();
const clients = computed( () => useGetClients().clientState.clients);

useFetchCompanies().getCompanies();
const companies = computed(() => useFetchCompanies().companyState.companies);
//**********************************************************************************************************************
// CLIENT ADD BUTTON

let isLoading = ref(false);
let clientAdd = reactive({
    name: '',
    email: '',
    password: '',
    company: ''
})

function showNotification() {
    const modalElement = document.getElementById('clientAdded');
    const modalInstance = new Modal(modalElement);

    modalInstance.show();

    setTimeout(() => {
        modalInstance.hide()
    }, 30000);
}

const {selectImage, file} = useImageFile();
function create() {
    useAddFile().addFile(file.value)
        .then((res) =>{
            clientAdd.image = res.data['@id'];
            return useCreateClients().createClient(clientAdd);
        })
        .then(() => {
            useGetClients().getClients();

            clientAdd.name = '';
            clientAdd.email = '';
            clientAdd.password = '';
            clientAdd.company = '';

            showNotification();
        })
}
//**********************************************************************************************************************
// CLIENT EDIT FUNCTION

let clientEdit = reactive({
    id: '',
    name: '',
    email: '',
    password: '',
    company: '',
})

function select(client) {
    clientEdit.id = client.id;
    clientEdit.name = client.name;
    clientEdit.email = client.email;
    clientEdit.password = client.password;
    clientEdit.company = client.company;
}

function change() {
    useChangeClients().changeClient(
        clientEdit.id, {
            name: clientEdit.name,
            email: clientEdit.email,
            password: clientEdit.password,
            company: clientEdit.company
        })
        .then(() => {
            useGetClients().getClients();

            clientEdit.name = '';
            clientEdit.email = '';
            clientEdit.password = '';
            clientEdit.company = '';
        })
}
//**********************************************************************************************************************
// DELETE FUNCTION
const selectedClientId = ref(null);

function confirmDelete(id) {
    selectedClientId.value = id;
}

function remove(id){
    useDeleteClient().deleteClient(id)
        .then(() => {
            useGetClients().getClients();
        })
}

//**********************************************************************************************************************
// SEARCHBAR FUNCTIONS

const searches = [
    {
        id: 'name',
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
        id: 'company.name',
        label: 'Company',
        placeholder: 'Ishlash joini qidirish'
    },
    {
        id:'lastActivityAt',
        label: 'Activity',
        type: 'date'
    }
]
const {selectedSearch, visibleSearches} = useSearchFilter(searches)

const searchStore = useSearchClients();

function searchClient(searchParams) {
    searchStore.searchClients(
        searchParams,
        'clients/getClients'
    )
        .then((res) => {
            useGetClients().clientState.clients = [...res.data.member].sort((a, b) => b.id - a.id);
        })
        .catch(() => {
            console.log('ERROR, search is failed');
        })
}
// *********************************************************************************************************************
// TABLE MODIFICATIONS

const thClientColumns = [
    'Mijozlar',
    'Email',
    'Parol',
    'Ishlash joyi',
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
//**********************************************************************************************************************
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
                class="client-filter"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches
                    v-bind:searches="visibleSearches"
                    @search="searchClient"
                />
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle text-start" id="dtClient">
                    <FormTable v-bind:th-columns="thClientColumns"/>
                    <tbody>
                    <tr v-for="client in clients" v-bind:key="client.id" class="del-edit-iconsClient">
                        <td class="client_tbNames-font">
                            <img
                                v-if="client.image"
                                v-bind:src="host + client.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{client.name}}
                        </td>
                        <td class="client-tbCol-font">{{client.email}}</td>
                        <td class="client-tbCol-font">{{client.password}}</td>
                        <td class="client-tbCol-font">{{client.company.name}}</td>
                        <td class="client-tbCol-font">{{formatLastActivity(client.lastActivityAt)}}</td>
                        <td class="penClient">
                            <FormEditPen
                                edit-modal-id="editClient"
                                @click="select(client)"
                            />
                        </td>
                        <td class="trashCanClient">
                           <FormDeleteTrash
                               edit-modal-id="editClient"
                               @click="confirmDelete(client.id)"
                               data-bs-toggle="modal"
                               data-bs-target="#confirmDeleteClient"
                           />
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
                <div class="modal-header">
                    <h5 class="modal-title modal-font-name">Mijoz malumotlarini kiriting</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="clientAdd.name"
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientAdd.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                 v-model="clientAdd.password"
                                 props-id="password"
                                 label-name="Password"
                                 input-type="text"
                                 placeholder="12345678"
                                 v-bind:required="true"
                            />
                            <FormSelect
                                v-model="clientAdd.company"
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Ish joyi"
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
                        @click="create"
                        v-bind:loading="isLoading"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editClient" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center">
                    <h5 class="modal-title modal-font-name">Malumotlarni o'zgartiring</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="clientEdit.name"
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientEdit.email"
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="clientEdit.password"
                                props-id="password"
                                label-name="Password"
                                input-type="text"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                            <FormSelect
                                v-model="clientEdit.company"
                                v-bind:options="companies"
                                props-id="company"
                                label-name="Ish joyi"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton
                        text="Qo'shish"
                        @click="change()"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-client-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteClient" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="client-del-name">Rostan ham o'chirilsinmi ?</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Ha"
                            class="client-del-btn client-del-red me-4 del-icon-pos"
                            @click="remove(selectedClientId)"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />

                        <FormButton
                            type="button"
                            text="Yo'q"
                            class="client-del-btn client-del-green del-icon-pos"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNotificationModal
        modal-id="clientAdded"
        text="Mijoz muaffaqiyatli qushildi !"
        class="font-poppins_name"
    />
</template>

<style scoped>
.client-tbCol-font {
    font-family: "Poppins",serif !important;
    color: #707683 !important;
    font-size: 13px;
    font-weight: 400 !important;
    line-height: 100% !important;
}
.client_tbNames-font {
    font-family: "Poppins", serif !important;
    color: #323C47 !important;
    font-size: 15px;
    font-weight: 500 !important;
    line-height: 100% !important;
}
.client-filter{
    font-family: 'Poppins',serif !important;
    font-weight: 400 !important;
    font-size: 12px !important;
    line-height: 100% !important;
    color: #707683 !important;
    padding: 10px 0 10px 0;
}
.modal-font-name {
    font-family: "Poppins",serif !important;
    font-weight: 600 !important;
    line-height: 100% !important;
    font-size: 13px !important;
}
.button-client-edit{
    width: 108px !important;
    height: 29px !important;
    line-height: 24px !important;
}
.client-del-btn{
    width: 94px;
    height: 30px;
    border-radius: 2px;
}
.client-del-red{
    background-color: #F7685B;
}
.client-del-green{
    background-color: #34D47E;
}
.client-del-name{
    font-family: "Poppins", sans-serif !important;
    color: #000000;
    font-size: 15px;
    font-weight: 400;
    line-height: 100%;
}

.del-edit-iconsClient{
    cursor: pointer;
    .penClient > * {
        display: none;
    }
    .trashCanClient > * {
        display: none;
    }
}
.del-edit-iconsClient:hover{
    .penClient > * {
        display: table-cell;
    }
    .trashCanClient > *{
        display: table-cell;
    }
}

#dtClient th:nth-child(1),
#dtClient td:nth-child(1) {
    width: 20%;
}

#dtClient th:nth-child(2),
#dtClient td:nth-child(2) {
    width: 21%;
}

#dtClient th:nth-child(3),
#dtClient td:nth-child(3) {
    width: 21%;
}

#dtClient th:nth-child(4),
#dtClient td:nth-child(4) {
    width: 20%;
}

#dtClient th:nth-child(5),
#dtClient td:nth-child(5){
    width: 12%;
}
#dtClient th:nth-child(6),
#dtClient td:nth-child(6) {
    width: 4%;
}
#dtClient th:nth-child(7),
#dtClient td:nth-child(7) {
    width: 3%;
}

</style>