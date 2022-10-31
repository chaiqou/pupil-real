<template>
    <Form @submit="onSubmitMerchantForm">
        <Field name="title" type="text" />
        <Field name="description" type="text" />
        <Datepicker v-model="store.dateRange" range />
        <Field name="period" type="number" />
        <MerchantRadioGroup />
    </Form>
</template>

<script setup>
import { Form, Field } from "vee-validate";
import MerchantRadioGroup from "./MerchantRadioGroup.vue";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

const store = useMerchantFormStore();

function onSubmitMerchantForm(values) {
    console.log(date.value);
}
</script>
