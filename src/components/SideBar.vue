<script setup>
import {useRouter} from "vue-router";

const router = useRouter()

function logOut(){
    localStorage.removeItem('token');
    router.push('/login')
}

import {useToggleSidebar} from "@/stores/sidebar/toggleSidebar.js";
const toggle = useToggleSidebar();

</script>

<template>
    <aside
        class="d-flex flex-column bg-body-white vh-100 shadow sidebar position-fixed top-0 start-0 mobile-open"
        v-bind:class="{'expand': toggle.isExpanded}"
    >
        <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <router-link to="/" class="nav-link border-bottom rounded-0 brand-height">
                        <span class="brand-full">Fathullo Inc</span> <br/>
                    </router-link>
                </li>
            <a href="#" class="nav-link d-flex mt-3">
                <img class="rounded-circle img-fluid img" src="@/assets/imgboy_1.jpg" alt="#">
                <div>
                    <span class="ms-3">Fathullo</span><br/>
                    <span class="ms-3 gmail_size">fathullolimov@gmail.com</span>
                </div>
            </a>
            <li class="nav-item">
                <router-link class="nav-link" to="/user-info">
                    <i class="bi bi-person-plus p-2 sidebar-icon icon_size"></i>
                    <span>Users</span>
                 </router-link>
            </li>
            <li class="nav-item">
                <router-link class="nav-link" to="/company-info">
                    <i class="bi bi-buildings p-2 sidebar-icon icon_size"></i>
                    <span>Companies</span>
                </router-link>
                </li>
            <li class="nav-item">
                 <router-link class="nav-link" to="/clients-info">
                    <i class="bi bi-people p-2 sidebar-icon icon_size"></i>
                    <span>Customers</span>
                 </router-link>
            </li>
            <hr/>
            <li class="nav-item">
                <router-link class="nav-link" to="/settings">
                    <i class="bi bi-gear p-2 sidebar-icon icon_size"></i>
                    <span>Settings</span>
                </router-link>
            </li>
            <li class="nav-item">
                <router-link @click="logOut()" class="nav-link" to="/login">
                    <i class="bi bi-box-arrow-right p-2 sidebar-icon icon_size"></i>
                    <span>Log out</span>
                </router-link>
            </li>
        </ul>
        <div class="mt-auto">
            <button
                class="nav-link btn btn-link p-3 text-decoration-none"
                id="toggleSidebar"
                @click="toggle.toggleSidebar()"
            >
                <i class="bi bi-arrows-collapse-vertical p-2 icon_size"></i>
                <span>Collapse</span>
            </button>
        </div>
    </aside>
</template>

<style scoped>

.gmail_size {
    font-size: 11px !important;
    font-weight: 500 !important;
    color: #707683 !important;
}

.brand-full {
    font-size: 18px !important;
    color: #109CF1 !important;
    font-weight: 600 !important;
    font-family: Open Sans,ui-sans-serif;
    letter-spacing: 1% !important;
    margin-top: 17px !important;
    margin-left: 24px !important;
}

.icon_size{
    width: 16px !important;
    height: 16px !important;
    border-radius: 1px !important;
    color: #98A5B6;
}
span{
    font-size: 13px !important;
    color: #334D6E !important;
    font-weight: 500 !important;
    height: 100%;
    letter-spacing: 1%;
}

aside .nav-link {
    text-decoration: none !important;
    color: inherit !important;
}

aside .nav-link.router-link-active {
    color: #109CF1 !important;
}

aside .nav-link.router-link-active .sidebar-icon {
    color: #109CF1 !important;
}

aside .nav-link{
    font-family: "Poppins", sans-serif;
}

.brand-height {
    height: 60px !important;
}

</style>