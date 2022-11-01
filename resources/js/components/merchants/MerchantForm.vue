<template>
    <Form class="mt-[4.2rem]" @submit="onSubmitMerchantForm">
        <MerchantLabel label="Title" />
        <Field
            v-model="store.title"
            name="title"
            type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Description" />
        <Field
            v-model="store.description"
            name="description"
            type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Active Range" />
        <Datepicker v-model="store.dateRange" range />
        <MerchantLabel label="Period Length" />
        <Field
            v-model="store.period"
            name="period"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantRadioGroup />
        <MerchantLabel label="Holds" />
        <Datepicker v-model="store.holds" range />
        <MerchantLabel label="Extras" />
        <Datepicker v-model="store.extras" range />
        <TagInput />
        <MerchantLabel label="Price/Day" />
        <Field
            v-model="store.priceDay"
            name="priceDay"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Price/Period" />
        <Field
            v-model="store.pricePeriod"
            name="pricePeriod"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <button type="submit">Save Period</button>
    </Form>
</template>

<script setup>
import { Form, Field } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

import MerchantRadioGroup from "./MerchantRadioGroup.vue";
import MerchantLabel from "./MerchantLabel.vue";
import TagInput from "./TagInput.vue";

const store = useMerchantFormStore();

function onSubmitMerchantForm(value) {
    console.log(store.getMerchantData);
}
</script>
