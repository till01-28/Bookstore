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
    password: ''
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
            userAdd.password = '';

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
    password: ''
})

function select(user) {
    userEdit.id = user.id;
    userEdit.givenName = user.givenName;
    userEdit.familyName = user.familyName;
    userEdit.email = user.email;
    userEdit.password = user.password;
}

function change(){
    useChangeUser().changeUser(
       userEdit.id, {
            familyName: userEdit.familyName,
            givenName: userEdit.givenName,
            email: userEdit.email,
            password: userEdit.password,
        })
        .then(() => {
            useGetUsers().getUsers();

            userEdit.givenName = '';
            userEdit.familyName = '';
            userEdit.email = '';
            userEdit.password = '';
        })
}

//**********************************************************************************************************************
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
        id: 'password',
        label: 'Parol',
        placeholder: 'Parol buyicha qidirish'
    },
    {
        id: 'lastActivityAt',
        label: 'So\'ngi faollik',
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
            useGetUsers().userState.users = res.data.member;
        })
        .catch(() => {
            console.log('ERROR, search is failed');
        });
}
//*********************************************************************************************************************
// Table modifications

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

    const diff = now - activityDate;

    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    const months = Math.floor( days / 30);

    const time = activityDate.toLocaleTimeString('uz-UZ', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });

    if (seconds < 60) {
        return `Hozirgina ${time}`;
    }

    if (minutes < 60) {
        return `${minutes} daqiqa oldin ${time}`;
    }

    if (hours < 24) {
        return `${hours} soat oldin ${time}`;
    }

    if (days < 30) {
        return `${days} kun oldin ${time}`;
    }

    if (months < 12) {
        return `${months} oy oldin ${time}`;
    }

    return `${activityDate.toLocaleDateString('uz-UZ', {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    })} ${time}`;
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
                    <tr
                        v-for="user in users"
                        v-bind:key="user.id">
                        <td>
                            <img
                                v-if="user.image"
                                v-bind:src="host + user.image.contentUrl"
                                class="rounded-circle me-2 m-2 img-table"
                                alt="image"
                            >
                            {{user.familyName}}
                            {{user.givenName}}
                        </td>
                        <td>{{user.email}}</td>
                        <td>{{user.password.substring(7,20)}}</td>
                        <td>{{formatLastActivity(user.lastActivityAt)}}</td>
                        <td>
                           <FormEditPen
                               edit-modal-id="editUser"
                               @click="select(user)"
                           />
                        </td>
                        <td>
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
                <div class="modal-header text-center ">
                    <h5 class="modal-title">Foydalanuvchi malumotlarini kiriting</h5>
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
                                v-model="userAdd.password"
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
                    />
                    <FormButton
                        text="Yopish"
                        data-bs-dismiss="modal"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editUser" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title ms-3">Malumotlarni o'zgartiring</h5>
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
                                v-model="userEdit.password"
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
                        text="O'zgartiish"
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
    <div class="modal fade" id="confirmDeleteUser" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content rounded-0 border-0">
                <div class="d-flex justify-content-around align-items-center m-3">
                    <span class="h5">Rostan ham o'chirilsinmi ?</span>
                    <div>
                        <FormButton
                            type="button"
                            text="Ha"
                            class="btn btn-danger rounded-0 px-3 mx-3"
                            @click="remove(selectedUserId)"
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
    <FormNotificationModal modal-id="userAdded" text="Foydalanuvchi muaffaqiyatli qushildi !"/>
</template>

<style>
</style>