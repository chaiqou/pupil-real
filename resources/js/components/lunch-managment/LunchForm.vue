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
            <label
                class="text-md flex font-bold text-gray-600 whitespace-normal"
                >Active Range
            </label>
            <Datepicker
                closeOnScroll
                :minDate="new Date()"
                :maxDate="addYears(new Date(), 1)"
                :partialRange="false"
                @update:modelValue="handleActiveDate"
                :enableTimePicker="false"
                v-model="activeRange"
                @cleared="clearDatepicker"
                range
            />
            <WeekdaysChechkbox name="weekdays" />
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
import { addYears, format } from "date-fns";
import { ref } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import axios from "@/config/axios/index";
import BaseInput from "@/components/form-components/BaseInput.vue";
import Multiselect from "@vueform/multiselect";
import WeekdaysChechkbox from "@/components/lunch-managment/WeekdaysCechkbox.vue";
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import Button from "@/components/ui/Button.vue";

const store = useLunchFormStore();
const { handleSubmit } = useForm();

const multiselectRef = ref(null);
const activeRange = ref(null);

const handleActiveDate = (modelData) => {
    if (modelData) {
        store.active_range.push([
            format(modelData[0], "yyyy-MM-dd"),
            format(modelData[1], "yyyy-MM-dd"),
        ]);
    }
};

const onSubmit = handleSubmit((values, { resetForm }) => {
    store.getFullLengthOfDays;

    axios
        .post("/school/lunch", store.getLunchFormData)
        .then(() => {
            resetForm();
            multiselectRef.value.clear();
        })
        .catch((error) => {
            console.log(error);
        });

    store.extras = [];
    store.holds = [];
    store.disabled_hold_days = [];
    store.disabled_extra_days = [];
});

const clearDatepicker = () => {
    store.findMiddleRangeDates("active_range", store.active_range);
    store.formatDateForHumans("active_range", store.active_range);
    store.findMiddleRangeDates("add_extras", store.extras);

    let filteredMarkedDays = store.active_range.filter(
        (x) => !store.add_marked_extras.includes(x)
    );

    let difference = store.marked_days.filter(
        (x) => !filteredMarkedDays.includes(x)
    );

    store.marked_days = difference;

    store.active_range = [];
    store.toggle_based_weekdays = [];
    store.disabled_hold_days = [];
    store.holds = [];
};

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
