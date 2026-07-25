<script setup>
import Modal from "@/components/Modal.vue";
import NavBar from "@/components/NavBar.vue";
import TableRow from "@/components/TableRow.vue";
import SideBar from "@/components/SideBar.vue";
import SearchBars from "@/components/SearchBars.vue";

import {useToggleSidebar} from "@/store/toggleSidebar.js";

const toggle = useToggleSidebar();

</script>

<template>
    <div class="container-fluid d-flex p-0">
        <SideBar/>
        <div class="col table-content background-color" v-bind:class="{'sidebar-expanded': toggle.isExpanded}">
            <NavBar/>
            <div class="container-fluid">
                <SearchBars/>
                <TableRow/>
            </div>
        </div>
        <Modal/>
    </div>
</template>

<style scoped>

.background-color{
    background-color: #F5F6F8;
    min-height: 100vh;
}

.table-content{
    margin-left: 70px;
    min-width: 0;
}

.table-content.sidebar-expanded{
    margin-left: 300px;
}

</style>