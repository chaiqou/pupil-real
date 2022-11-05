<template>
    <div class="mt-[4.2rem] w-96">
        <BaseInput name="title" label="Title" />
        <BaseInput name="description" label="Description" />
        <BaseInput name="period_length" label="Period Length" />
        <BaseInput name="price_day" label="Price per day" />
        <BaseInput name="price_period" label="Price per period" />
    </div>
</template>

<script setup>
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";
import axios from "../../config/axios/index";
import BaseInput from "../form-components/BaseInput";

const store = useMerchantFormStore();

function onSubmitMerchantForm(value) {
    axios
        .post("lunch", store.getMerchantData)
        .then((response) => {
            console.log(response);
        })
        .catch((error) => {
            console.log(error);
        });
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
