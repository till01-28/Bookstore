<script setup>
import FormButton from "@/components/tags/FormButton.vue";
import FormInput from "@/components/tags/FormInput.vue";
import FormSelect from "@/components/tags/FormSelect.vue";

defineProps({
    componentId: {
        type: String,
        required: true
    },
    modalName: {
        type: String,
        required: true
    },
    modalType: {
        type: String,
        default: "user"
    }
})
</script>

<template>
    <div class="modal fade" v-bind:id="componentId" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 rounded-0">
                <div class="modal-header text-center ">
                    <h5 class="modal-title">{{modalName}}</h5>
                </div>
                <div class="modal-body pt-0 pb-0">
                    <form>
                        <div>
                            <FormInput
                                props-id="name"
                                label-name="To'liq Ism"
                                input-type="name"
                                placeholder="Fathullo Olimov"
                                v-bind:required="true"
                            />
                            <FormInput
                                props-id="email"
                                label-name="Email"
                                input-type="email"
                                placeholder="fathullolimov@gmail.com"
                                v-bind:required="true"
                            />
                            <FormInput
                                v-if="modalType !== 'client'"
                                props-id="password"
                                label-name="Password"
                                input-type="password"
                                placeholder="12345678"
                                v-bind:required="true"
                            />
                            <FormSelect
                                v-if="modalType === 'client'"
                                props-id="company"
                                label-name="Ish joyi"
                                v-bind:options="companies"
                                v-bind:required="true"
                            />

                            <FormInput
                                props-id="file"
                                label-name="Rasm tanlang"
                                input-type="file"
                                v-bind:required="true"
                            />
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                    <FormButton text="Qo'shish" data-bs-dismiss="modal"/>
                    <FormButton text="Yopish" data-bs-dismiss="modal"/>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
.modal-backdrop.show {
    opacity: 0.1;
}

.modal-content {
    background-color: #ffffff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.18);
}
</style>