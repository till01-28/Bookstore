<script setup>

import {useToggleSidebar} from "@/stores/toggleSidebar.js";

const toggle = useToggleSidebar();

</script>

<template>
    <aside
        class="d-flex flex-column bg-body-white vh-100 shadow sidebar position-fixed top-0 start-0 mobile-open"
        v-bind:class="{'expand': toggle.isExpanded}"
    >
        <ul class="nav nav-pills flex-column">
            <router-link to="/" class="nav-link py-4 border-bottom rounded-0">
                <li class="nav-item">
                    <i class="bi bi-house h5 p-2 text-black-50 sidebar-icon"></i>
                    <span class="brand-full">Fathullo Inc</span>
                </li>
            </router-link>
            <a href="#" class="nav-link d-flex mt-3">
                <img class="rounded-circle img-fluid img" src="@/assets/logo.jpg" alt="#">
                <div class="text-black-50">
                    <span class="ms-3 text-dark">Fathullo</span><br/>
                    <span class="ms-3 gmail">fathullolimov@gmail.com</span>
                </div>
            </a>
            <router-link to="/user-info" class="nav-link text-black-50">
                <li class="nav-item">
                    <i class="bi bi-person p-2 h5 sidebar-icon"></i>
                    <span>Add User</span>
                </li>
            </router-link>
            <router-link to="/company-info" class="nav-link text-black-50">
                <li class="nav-item">
                    <i class="bi bi-buildings p-2 h5 sidebar-icon"></i>
                    <span>Companies</span>
                </li>
            </router-link>
            <router-link to="/clients-info" class="nav-link text-black-50">
                <li class="nav-item">
                    <i class="bi bi-people p-2 h5 sidebar-icon"></i>
                    <span>Customers</span>
                </li>
            </router-link>
            <hr/>
            <a href="#" class="nav-link text-black-50">
                <li class="nav-item">
                    <i class="bi bi-gear p-2 h5 sidebar-icon"></i>
                    <span>Settings</span>
                </li>
            </a>
            <router-link to="/login" class="nav-link text-black-50">
                <li class="nav-item">
                    <i class="bi bi-box-arrow-right p-2 h5 sidebar-icon"></i>
                    <span>Log out</span>
                </li>
            </router-link>
        </ul>
        <div class="mt-auto">
            <button class="nav-link btn btn-link p-3 text-decoration-none" id="toggleSidebar" @click="toggle.toggleSidebar()">
                <i class="bi bi-arrows-collapse-vertical p-2 h5"></i>
                <span>Collapse</span>
            </button>
        </div>
    </aside>
</template>

<style scoped>

.sidebar .router-link-active .sidebar-icon {
    color: #0d6efd !important;
}

</style>