<template>
    <Form
        class="mt-[4.2rem] w-96"
        :validation-schema="schema"
        @submit="onSubmitMerchantForm"
    >
        <MerchantLabel label="Title" />
        <Field
            v-model="store.title"
            name="title"
            type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="title" />
        <MerchantLabel label="Description" />
        <Field
            v-model="store.description"
            name="description"
            type="text"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="description" />
        <MerchantLabel label="Active Range" />
        <Datepicker v-model="store.dateRange" range name="dateRange" />
        <MerchantLabel label="Period Length" />
        <Field
            v-model="store.period"
            name="period"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="period" />
        <MerchantRadioGroup name="day" />
        <MerchantLabel label="Holds" />
        <Datepicker v-model="store.holds" range name="holds" />
        <MerchantLabel label="Extras" />
        <Datepicker v-model="store.extras" range name="extras" />
        <MerchantLabel label="Claimables" />
        <Multiselect
            class="mt-8"
            v-model="store.tags"
            mode="tags"
            :limit="10"
            :max="4"
            :close-on-select="false"
            :searchable="true"
            :options="mealOptions"
            @change="updateSelectedMeal"
            name="claimables"
        />
        <MerchantLabel label="Price/Day" />
        <Field
            v-model="store.priceDay"
            name="priceDay"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="priceDay" />
        <MerchantLabel label="Price/Period" />
        <Field
            v-model="store.pricePeriod"
            name="pricePeriod"
            type="number"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="pricePeriod" />
        <button
            type="submit"
            class="inline-flex mt-4 w-full text-center items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            Save Period
        </button>
    </Form>
</template>

<script setup>
import { Form, Field } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";
import MerchantRadioGroup from "./MerchantRadioGroup.vue";
import MerchantLabel from "./MerchantLabel.vue";
import Multiselect from "@vueform/multiselect";
import MerchantErrorMessage from "./MerchantErrorMessage.vue";
import { object, string, mixed } from "yup";

const store = useMerchantFormStore();

const schema = object({
    title: string().required(),
    description: string().required(),
    period: string().required().nullable(),
    priceDay: string().required("Price/Day is required.").nullable(),
    pricePeriod: string().required("Price/Period is required.").nullable(),
});

function onSubmitMerchantForm(value) {
    console.log(store.getMerchantData.dateRange);
}

function updateSelectedMeal(value) {
    console.log(value);
}

const mealOptions = [
    "Breakfast",
    "Lunch",
    "Dinner",
    "Snack",
    "Dessert",
    "Drink",
    "Appetizer",
    "Salad",
    "Bread",
    "Cereal",
    "Soup",
    "Beverage",
    "Sauce",
    "Marinade",
    "Fingerfood",
    "Salsa",
    "Dip",
];
</script>

<style src="@vueform/multiselect/themes/default.css" />
<style>
body {
    --ms-bg: transparent;
    --ms-tag-bg: #6c757d;
    --ms-border-color: #6c757d;
}

.multiselect-tags-search {
    background-color: inherit;
}
</style>
