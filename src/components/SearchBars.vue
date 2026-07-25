<script setup lang="ts">

</script>

<template>
    <div class="m-2">
        <span class="ms-4">Kompaniya:</span>
        <span class="d-inline-block">
                    <select class="form-select border-0 rounded-0 shadow-none">
                        <option selected>Hammasi</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </span>
    </div>
    <div class="row ps-4 pe-4 g-4">
        <div class="col-12 col-md-6 col-xl-3">
            <div class="input-group shadow">
                <span class="input-group-text rounded-0 border-0 bg-white"><i class="bi bi-search my-2 ms-3"></i></span>
                <input type="text" class="form-control border-0 rounded-0 shadow-none" placeholder="Foydalanuvchini qidirish"/>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="input-group shadow">
                <span class="input-group-text rounded-0 border-0 bg-white"><i class="bi bi-search my-2 ms-3"></i></span>
                <input type="text" class="form-control border-0 rounded-0 shadow-none" placeholder="Email qidirish"/>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="input-group shadow">
                <span class="input-group-text rounded-0 border-0 bg-white"><i class="bi bi-search my-2 ms-3"></i></span>
                <input type="text" class="form-control border-0 rounded-0 shadow-none" placeholder="Parol qidirish"/>
            </div>
        </div>
        <div class="col-12 col-md-6 col-xl-3">
            <div class="input-group shadow">
                <span class="input-group-text rounded-0 border-0 bg-white"><i class="bi bi-search my-2 ms-3"></i></span>
                <input type="text" class="form-control border-0 rounded-0 shadow-none" placeholder="So'nggi faollikni qidirish"/>
            </div>
        </div>
    </div>
</template>

<style scoped>

.form-select{
    background-color: #F5F6F8;
    color:deepskyblue;
}

</style>