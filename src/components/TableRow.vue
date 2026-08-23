<script setup>
defineProps({
    thColumns: {
        type: Array,
        default: () => []
    },
    tableRows: {
        type: Array,
        default: () => []
    },
    editModalId:{
        type: String,
        required: true,
    }

})
</script>

<template>
    <div class="container-fluid">
        <div class="table-responsive rounded-2">
            <table class="table table-hover align-middle text-center" id="dataTable">
                <thead>
                <tr>
                    <th v-for="(column, index) in thColumns" v-bind:key="index">
                        {{column}}
                    </th>
                </tr>
                </thead>
                <tbody class="table_dimensions">
                <tr v-for="row in tableRows" v-bind:key="row.id">
                    <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table" alt="#">
                        {{row.name}}
                    </td>
                    <td>{{row.email}}</td>
                    <td>{{row.password}}</td>
                    <td>{{row.lastActivityAt}}</td>
                    <td>
                        <i
                        class="icon-link icon-link-hover link-success link-underline-success bi bi-pencil-fill"
                        data-bs-toggle="modal"
                        v-bind:data-bs-target="`#${editModalId}`"
                        >
                        </i>
                    </td>
                    <td>
                        <i class="icon-link icon-link-hover link-danger link-underline-danger bi bi-trash-fill">
                        </i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

</style>