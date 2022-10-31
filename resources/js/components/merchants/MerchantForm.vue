<template>
    <Form @submit="onSubmitMerchantForm">
        <Field v-model="title" name="title" type="text" />
        <Field v-model="description" name="description" type="text" />
        <Datepicker v-model="store.dateRange" range />
        <Field v-model="period" name="period" type="number" />
        <MerchantRadioGroup />
        <Datepicker v-model="store.holds" range />
        <Datepicker v-model="store.extras" range />
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
