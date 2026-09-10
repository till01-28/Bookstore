<script setup>
defineProps({
    labelName:{
        type: String,
        required: true,
    },
    propsId:{
        required: true,
    },
    inputType: {
        default: "text"
    },
    placeholder:{
        type: String,
    },
    required:{
        type: Boolean,
        default: false
    },
    modelValue: {
        type: String,
        default: ''
    }
})

defineEmits(["update:modelValue"])
</script>

<template>
    <div class="mt-3">
        <label v-bind:for="propsId" class="form-label">{{labelName}}
            <i v-if="required" class="bi bi-asterisk asterisk"></i></label>
        <input
            @input="$emit('update:modelValue',$event.target.value)"
            v-bind:id="propsId"
            v-bind:type="inputType"
            v-bind:placeholder="placeholder"
            v-bind:value="modelValue"
            class="form-control"/>
    </div>
</template>

<style scoped>

</style>