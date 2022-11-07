<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ label }}
        </label>
        <Multiselect
            class="mt-8"
            mode="tags"
            :limit="10"
            :max="4"
            :close-on-select="false"
            :searchable="true"
            :options="mealOptions"
            @change="updateSelectedMeal"
            v-model="value"
        />
        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{
            errorMessage
        }}</span>
    </div>
</template>

<script setup>
import Multiselect from "@vueform/multiselect";
import { useField } from "vee-validate";
import { defineProps, toRef } from "vue";

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});

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

function required(value) {
    if (value) {
        return true;
    }
    return "This field is required";
}

const nameRef = toRef(props, "name");
const { errorMessage, value } = useField(nameRef, required);
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
