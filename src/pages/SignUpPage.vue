<script setup>
import FormInput from "@/components/tags/FormInput.vue";
import FormButton from "@/components/tags/FormButton.vue";
</script>

<template>
    <div class="row vh-100 justify-content-center align-items-center">
        <div class="col-12 col-sm-8 col-md-8 col-xl-4">
            <form class="border rounded">
                <h1 class="text-center mt-3">Sign Up Form</h1>
                    <div class="m-3">
                        <FormInput props-id="givenName" label-name="Given Name" input-type="givenName"/>
                        <FormInput props-id="familyName" label-name="Family Name" input-type="familyName"/>
                        <FormInput props-id="email" label-name="Email" input-type="email"/>
                        <FormInput props-id="password" label-name="Create password" input-type="password"/>
                        <FormInput props-id="password" label-name="Enter password again" input-type="password"/>
                    </div>
                <div class="m-3 d-flex justify-content-between align-items-center">
                    <span
                        class="">If you have an account.
                        Click <router-link to="/login" class="text-decoration-none">Log In</router-link>
                    </span>
                    <FormButton text="Sign Up" type="button" class="btn btn-primary"/>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>