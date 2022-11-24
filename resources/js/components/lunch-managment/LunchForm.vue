<template>
    <div class="sm:mt-20 min-w-[30vw] xl:px-4">
        <form @submit.prevent="onSubmit">
            <p class="mb-2 text-center text-xl font-black">
                Create new lunch plan
            </p>
            <BaseInput v-model="store.title" name="title" label="Title" />
            <BaseInput
                v-model="store.description"
                name="description"
                label="Description"
            />
            <RangeDatepicker
                v-model="store.active_range"
                name="active_range"
                label="Active range"
            />
            <ExtrasAndHolds holds="holds" extras="extras" />
            <BaseInput
                v-model="store.period_length"
                name="period_length"
                label="Period Length"
                type="number"
            />
            <label
                class="text-md flex font-bold text-gray-600 whitespace-normal"
                >Claimables
            </label>
            <Multiselect
                v-model="store.claimables"
                mode="tags"
                name="claimables"
                :limit="10"
                :max="10"
                ref="multiselectRef"
                required
                autocomplete
                appendNewOption
                searchable
                :createOption="true"
                :close-on-select="false"
                :searchable="true"
                :options="multiselectOptions"
            />
            <WeekdaysChechkbox name="tags" />
            <BaseInput
                v-model="store.price_day"
                name="price_day"
                label="Price per day"
                type="number"
            />
            <BaseInput
                v-model="store.price_period"
                name="price_period"
                label="Price per period"
                type="number"
            />
            <Button text="Save Lunch" />
        </form>
    </div>
</template>

<script setup>
import { useForm } from "vee-validate";
import { ref } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import axios from "../../config/axios/index";
import BaseInput from "@/components/form-components/BaseInput.vue";
import RangeDatepicker from "@/components/form-components/RangeDatepicker.vue";
import Multiselect from "@vueform/multiselect";
import WeekdaysChechkbox from "@/components/lunch-managment/WeekdaysCechkbox.vue";
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import Button from "@/components/ui/Button.vue";

const store = useLunchFormStore();
const { handleSubmit } = useForm();

const multiselectRef = ref(null);

const onSubmit = handleSubmit((values, { resetForm }) => {
    store.loopThroughActiveRange();

    axios
        .post("lunch", store.getLunchFormData)
        .then(() => {
            resetForm();
            multiselectRef.value.clear();
        })
        .catch((error) => {
            console.log(error);
        });
});

const multiselectOptions = [
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
