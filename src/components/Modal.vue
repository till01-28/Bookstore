<script setup lang="ts">

</script>

<template>
    <div class="modal" id="addUser" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title">Foydalanuvchini qo'shish</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div>
                            <label class="form-label mt-2" for="first-name">Toliq Ism<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control mb-4" type="text" placeholder="Olimov Fathullo">

                            <label class="form-label " for="last-name">Email<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control mb-4" type="text" placeholder="example@gmail.com">

                            <label class="form-label" for="phone">Parol<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control" type="text" placeholder="1234567890">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <button type="button" class="btn btn-primary">Qo'shish</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="changeUser" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title">O'zgartirish</h5>
                </div>
                <div class="modal-body">
                    <form>
                        <div>
                            <label class="form-label mt-2" for="first-name">Toliq Ism<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control mb-4" type="text" placeholder="Olimov Fathullo">

                            <label class="form-label " for="last-name">Email<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control mb-4" type="text" placeholder="example@gmail.com">

                            <label class="form-label" for="phone">Parol<i class="bi bi-asterisk asterisk"></i></label>
                            <input class="form-control" type="text" placeholder="1234567890">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <button type="button" class="btn btn-primary">Qo'shish</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

.asterisk{
    color: deepskyblue;
    position: absolute;
    font-size: 6px;
    margin-top: 6px;
}

</style>