<template>
    <Form class="mt-[4.2rem] w-96" @submit="onSubmitMerchantForm">
        <MerchantLabel label="Title" />
        <Field
            v-model="store.title"
            name="title"
            type="text"
            rules="required"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Description" />
        <Field
            v-model="store.description"
            name="description"
            type="text"
            rules="required"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Active Range" />
        <Datepicker v-model="store.dateRange" range />
        <MerchantLabel label="Period Length" />
        <Field
            v-model="store.period"
            name="period"
            type="number"
            rules="required|numeric|min:1|max:31"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantRadioGroup rules="required" />
        <MerchantLabel label="Holds" />
        <Datepicker v-model="store.holds" range rules="required" />
        <MerchantLabel label="Extras" />
        <Datepicker v-model="store.extras" range rules="required" />
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
            rules="required"
        />
        <MerchantLabel label="Price/Day" />
        <Field
            v-model="store.priceDay"
            name="priceDay"
            type="number"
            rules="required|numeric|min:1|max:99999"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantLabel label="Price/Period" />
        <Field
            v-model="store.pricePeriod"
            name="pricePeriod"
            type="number"
            rules="required|numeric|min:1|max:99999"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <button
            type="submit"
            class="inline-flex mt-4 w-full text-center items-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
        >
            Save Period
        </button>
    </Form>
</template>

<script setup>
import { Form, Field, ErrorMessage } from "vee-validate";
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";

import MerchantRadioGroup from "./MerchantRadioGroup.vue";
import MerchantLabel from "./MerchantLabel.vue";
import Multiselect from "@vueform/multiselect";

const store = useMerchantFormStore();

function onSubmitMerchantForm(value) {
    console.log(store.getMerchantData);
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
