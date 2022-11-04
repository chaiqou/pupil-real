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
        <MerchantErrorMessage name="title" />
        <MerchantLabel label="Description" />
        <Field
            v-model="store.description"
            name="description"
            type="text"
            rules="required"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="description" />
        <MerchantLabel label="Active Range" />
        <Field v-model="store.dateRange" name="dateRange" rules="required">
            <Datepicker
                v-model="store.dateRange"
                name="dateRange"
                rules="required"
                range
            />
            <MerchantErrorMessage name="dateRange" />
        </Field>
        <MerchantLabel label="Period Length" />
        <Field
            v-model="store.period"
            name="period"
            type="number"
            rules="required"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="period" />
        <MerchantRadioGroup />
        <MerchantLabel label="Holds" />
        <Field v-model="store.holds" rules="required" name="holds">
            <Datepicker v-model="store.holds" range />
            <MerchantErrorMessage name="holds" />
        </Field>
        <MerchantLabel label="Extras" />
        <Field v-model="store.extras" rules="required" name="extras">
            <Datepicker v-model="store.extras" range />
            <MerchantErrorMessage name="extras" />
        </Field>
        <MerchantLabel label="Claimables" />
        <Field v-model="store.tags" rules="required" name="claimables">
            <Multiselect
                class="mt-8"
                mode="tags"
                :limit="10"
                :max="4"
                :close-on-select="false"
                :searchable="true"
                :options="mealOptions"
                @change="updateSelectedMeal"
                v-model="store.tags"
            />
            <MerchantErrorMessage name="claimables" />
        </Field>
        <MerchantLabel label="Price/Day" />
        <Field
            v-model="store.priceDay"
            name="priceDay"
            type="number"
            rules="required"
            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
        />
        <MerchantErrorMessage name="priceDay" />
        <MerchantLabel label="Price/Period" />
        <Field
            v-model="store.pricePeriod"
            name="pricePeriod"
            type="number"
            rules="required"
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
