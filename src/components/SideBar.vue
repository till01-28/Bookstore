<script setup>

import {useToggleSidebar} from "@/store/toggleSidebar.js";

const toggle = useToggleSidebar();

</script>

<template>
    <aside
        class="d-flex flex-column bg-body-white vh-100 shadow-lg sidebar position-fixed top-0 start-0"
        v-bind:class="{expand: toggle.isExpanded}"
    >
        <ul class="nav nav-pills flex-column">
            <a href="#" class="nav-link py-4 border-bottom rounded-0">
                <li class="nav-item">
                    <i class="bi bi-house p-2 h5"></i>
                    <span class="brand-full">Fathullo Inc</span>
                </li>
            </a>
            <a href="#" class="nav-link d-flex mt-3">
                <img class="rounded-circle img-fluid img" src="@/assets/logo.jpg" alt="#">
                <div class="text-black-50">
                    <span class="ms-3">Fathullo Olimov</span><br/>
                    <span class="ms-3">fathullolimov@gmail.com</span>
                </div>
            </a>
            <a href="#" class="nav-link">
                <li class="nav-item">
                    <i class="bi bi-person p-2 h5"></i>
                    <span class="text-black-50">Add User</span>
                </li>
            </a>
            <a href="#" class="nav-link">
                <li class="nav-item">
                    <i class="bi bi-buildings p-2 h5"></i>
                    <span class="text-black-50">Companies</span>
                </li>
            </a>
            <a href="#" class="nav-link">
                <li class="nav-item">
                    <i class="bi bi-people p-2 h5"></i>
                    <span class="text-black-50">Customers</span>
                </li>
            </a>
            <hr/>
            <a href="#" class="nav-link">
                <li class="nav-item">
                    <i class="bi bi-gear p-2 h5"></i>
                    <span class="text-black-50">Settings</span>
                </li>
            </a>
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

.img{
    width: 40px;
    height: 40px;
}
.sidebar {
    width: 70px;
    z-index: 1030;
}

.sidebar.expand {
    width: 300px;
}

.sidebar span {
    display: none;
}

.sidebar.expand span {
    display: inline;
}
</style>