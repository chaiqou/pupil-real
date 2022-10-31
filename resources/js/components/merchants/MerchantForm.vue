<template>
    <Form @submit="onSubmitMerchantForm">
        <Field name="title" type="text" />
        <Field name="description" type="text" />
        <Datepicker v-model="date" range />
        <Field name="period" type="number" />
        <button type="submit">click me</button>
    </Form>
</template>

<script setup>
import { ref } from "vue";
import { Form, Field } from "vee-validate";

const date = ref();

function onSubmitMerchantForm(values) {
    console.log(date.value);
}
</script>
