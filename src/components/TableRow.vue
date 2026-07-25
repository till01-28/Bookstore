<script setup lang="ts">

</script>

<template>
    <div class="mt-3 m-4">
        <div class="table-responsive rounded-1">
            <table class="table table-hover align-middle text-center" id="dataTable">
                <thead>
                <tr>
                    <th>Foydalanuvchilar</th>
                    <th>Email</th>
                    <th>Parol</th>
                    <th>So'ngi faollik</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table">Fathullo Olimov</td>
                    <td>fathullolimov@gmail.com</td>
                    <td>Freddi8_I</td>
                    <td>5 minut oldin</td>
                </tr>
                <tr>
                    <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table">Fathullo Olimov</td>
                    <td>fathullolimov@gmail.com</td>
                    <td>Freddi8_I</td>
                    <td>5 minut oldin</td>
                </tr>
                <tr>
                    <td><img src="@/assets/logo.jpg" class="rounded-circle me-2 m-2 img-table">Fathullo Olimov</td>
                    <td>fathullolimov@gmail.com</td>
                    <td>Freddi8_I</td>
                    <td>5 minut oldin</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style scoped>

/* Make table columns match search bar widths */
#dataTable {
    table-layout: fixed;     /* ← This is the key */
    width: 100%;
}

#dataTable th, #dataTable td {
    width: 25%;              /* 4 equal columns */
}

#dataTable th {
    padding: 12px 8px;
}

.img-table {
    width: 40px;
    height: 40px;
}

</style>