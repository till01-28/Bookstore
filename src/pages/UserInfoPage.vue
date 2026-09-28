<script setup>
import NavBar from "@/components/NavBar.vue";
import FormSearches from "@/components/tags/FormSearches.vue";
import FormFilter from "@/components/tags/FormFilter.vue";
import FormTable from "@/components/tags/FormTable.vue";
import FormEditPen from "@/components/tags/FormEditPen.vue";
import {useGetUsers} from "@/stores/users/getUsers.js";
import {computed, reactive, ref, watch} from "vue";
import {useSearchFilter} from "@/stores/searchFilter/getSearchFilter.js";
import {useAddFile} from "@/stores/mediaObject/addFile.js";
import {useCreateUser} from "@/stores/users/postUsers.js";
import FormDeleteTrash from "@/components/tags/FormDeleteTrash.vue";
import {useImageFile} from "@/stores/addFile/imageFile.js";
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
import {useChangeUser} from "@/stores/users/changeUser.js";
import {useDeleteUser} from "@/stores/users/deleteUsers.js";
import {useSearchUsers} from "@/stores/users/useSearchUsers.js";
import FormNotificationModal from "@/components/tags/FormNotificationModal.vue";
import {Modal} from 'bootstrap';
import {format, isToday, differenceInMinutes, differenceInHours} from 'date-fns';
import { uz } from 'date-fns/locale';


const host = import.meta.env.VITE_API_DOMEN;
useGetUsers().getUsers()
const users = computed( () => useGetUsers().userState.users)

// *********************************************************************************************************************
// User Add Button
let isLoading = ref(false)
let userAdd = reactive({
    givenName: '',
    familyName: '',
    email: '',
    plainPassword: ''
})

function showNotification() {
    const modalElement = document.getElementById('userAdded');
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
            userAdd.image = res.data['@id'];
            return useCreateUser().createUser(userAdd);
        })
        .then(() => {
            useGetUsers().getUsers();

            userAdd.givenName = '';
            userAdd.familyName = '';
            userAdd.email = '';
            userAdd.plainPassword = '';

            showNotification();
        })
}

// *********************************************************************************************************************
// User Edit Button

let userEdit = reactive({
    id: '',
    givenName: '',
    familyName: '',
    email: '',
    plainPassword: ''
})

function select(user) {
    userEdit.id = user.id;
    userEdit.givenName = user.givenName;
    userEdit.familyName = user.familyName;
    userEdit.email = user.email;
    userEdit.plainPassword = user.plainPassword;
}

function change(){
    useChangeUser().changeUser(
       userEdit.id, {
            familyName: userEdit.familyName,
            givenName: userEdit.givenName,
            email: userEdit.email,
            plainPassword: userEdit.plainPassword,
        })
        .then(() => {
            useGetUsers().getUsers();

            userEdit.givenName = '';
            userEdit.familyName = '';
            userEdit.email = '';
            userEdit.plainPassword = '';
        })
}

//**********************************************************************************************************************
// DELETE FUNCTION

const selectedUserId = ref(null);

function confirmDelete(id) {
    selectedUserId.value = id;
}
function remove(id){
    useDeleteUser().deleteUser(id)
        .then(() => {
            useGetUsers().getUsers()
        })
}

// *********************************************************************************************************************
// SEARCHBAR FUNCTION
const searches = [
    {
        id: 'familyName',
        label: 'Familiya',
        placeholder: 'Familiya buyicha qidirish'
    },
    {
        id: 'email',
        label:'Email',
        placeholder: 'Email buyicha qidirish'
    },
    {
        id: 'plainPassword',
        label: 'Parol',
        placeholder: 'Parol buyicha qidirish'
    },
    {
        id: 'lastActivityAt',
        label: 'Activity',
        type: 'date'
    }
]

const {selectedSearch, visibleSearches} = useSearchFilter(searches)

const searchStore = useSearchUsers();
function searchUser(searchParams) {
    searchStore.searchUsers(
        searchParams,
        'users/getCollectionOfUsers',
    )
        .then((res) => {
            useGetUsers().userState.users = [...res.data.member].sort((a, b) => b.id - a.id);
        })
        .catch(() => {
            console.log('ERROR, search is failed');
        });
}
//*********************************************************************************************************************
// TABLE MODIFICATIONS

const thUserColumns = [
    'Foydalanuvchilar',
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
    <NavBar button-name="Foydalanuvchi" modal-id="addUser"/>
    <div class="container-fluid">
        <div class="container-fluid">
            <FormFilter
                v-model="selectedSearch"
                v-bind:searches="searches"
                v-bind:show-entity="true"
                entity-name="Foydalanuvchilar:"
                class="user-filter"
            />
            <div class="d-flex justify-content-between align-items-center mb-3 gap-3 search-container">
                <FormSearches
                    v-bind:searches="visibleSearches"
                    @search="searchUser"
                />
            </div>
        </div>
        <div class="container-fluid">
            <div class="table-responsive rounded-2">
                <table class="table table-hover align-middle text-start" id="dataTable">
                    <FormTable v-bind:th-columns="thUserColumns"/>
                    <tbody>
                    <tr v-for="user in users" v-bind:key="user.id" class="del-edit-icons">
                        <td class="user-tbNames-font">
                            <img
                                v-if="user.image"
                                v-bind:src="host + user.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{user.familyName}}
                            {{user.givenName}}
                        </td>
                        <td class="user-tbCol-font">{{user.email}}</td>
                        <td class="user-tbCol-font">{{user.plainPassword}}</td>
                        <td class="user-tbCol-font">{{formatLastActivity(user.lastActivityAt)}}</td>
                        <td class="pen">
                           <FormEditPen
                               edit-modal-id="editUser"
                               @click="select(user)"
                           />
                        </td>
                        <td class="trashCan">
                            <FormDeleteTrash
                              @click="confirmDelete(user.id)"
                              data-bs-toggle="modal"
                              data-bs-target="#confirmDeleteUser"
                            />
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addUser" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center">
                    <h5 class="modal-title modal-font-name">Foydalanuvchi malumotlarini kiriting</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="userAdd.familyName"
                                props-id="addFamilyName"
                                label-name="Familiya"
                                input-type="name"
                                placeholder="Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userAdd.givenName"
                                props-id="addGivenName"
                                label-name="Ism"
                                input-type="name"
                                placeholder="Fathullo"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userAdd.email"
                                props-id="addEmail"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userAdd.plainPassword"
                                props-id="addPassword"
                                label-name="Password"
                                input-type="text"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                            <FormInput
                                @change="selectImage($event)"
                                props-id="addFile"
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
                        class="button-user-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-user-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center">
                    <h5 class="modal-title modal-font-name">Malumotlarni o'zgartiring</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                v-model="userEdit.familyName"
                                props-id="editFamilyName"
                                label-name="Familiya"
                                input-type="name"
                                placeholder="Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userEdit.givenName"
                                props-id="editGivenName"
                                label-name="Ism"
                                input-type="name"
                                placeholder="Fathullo"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userEdit.email"
                                props-id="editEmail"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-model="userEdit.plainPassword"
                                props-id="editPassword"
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
                        @click="change()"
                        text="Qo'shish"
                        data-bs-dismiss="modal"
                        class="button-user-edit"
                        v-bind:font-weight="400"
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                        class="button-user-edit"
                        v-bind:font-weight="400"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="confirmDeleteUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="user-del-name">Rostan ham o'chirilsinmi ?</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Ha"
                            class="user-del-btn user-del-red me-4 del-icon-pos"
                            @click="remove(selectedUserId)"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />
                        <FormButton
                            type="button"
                            text="Yo'q"
                            class="user-del-btn user-del-green del-icon-pos"
                            data-bs-dismiss="modal"
                            v-bind:font-weight="400"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <FormNotificationModal modal-id="userAdded" text="Ma'lumot muaffaqiyatli qushildi!"/>
</template>

<style scoped>
.user-tbCol-font {
    font-family: "Poppins", sans-serif !important;
    color: #707683 !important;
    font-weight: 400 !important;
    font-size: 13px;
    line-height: 100% !important;

}
.user-tbNames-font {
    font-family: "Poppins", sans-serif !important;
    color: #323C47 !important;
    font-size: 15px;
    line-height: 100% !important;
    font-weight: 500 !important;
}
.user-filter {
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
.button-user-edit{
    width: 108px !important;
    height: 29px !important;
    line-height: 24px !important;
}

.user-del-btn{
    width: 94px;
    height: 30px;
    border-radius: 2px;
}
.user-del-red{
    background-color: #F7685B;
}
.user-del-green{
    background-color: #34D47E;
}
.user-del-name{
    font-family: "Poppins", sans-serif !important;
    color: #000000;
    font-size: 15px;
    font-weight: 400;
    line-height: 100%;
}

</style>