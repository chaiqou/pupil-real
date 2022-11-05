<template>
    <BaseInput name="title" label="Title" />
</template>

<script setup>
import { useMerchantFormStore } from "../../stores/useMerchantFormStore";
import axios from "../../config/axios/index";
import BaseInput from "../form-components/BaseInput.vue";

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
