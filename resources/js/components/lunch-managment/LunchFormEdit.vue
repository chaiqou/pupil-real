<template>
    <div class="sm:mt-20 w-1/3 px-20 float-right">
        <form @submit.prevent="onSubmit">
            <p class="mb-2 text-center text-xl font-black">
                Create new lunch plan
            </p>
            <BaseInput v-model="lunches.title" name="title" label="Title" />
            <BaseInput
                v-model="lunches.description"
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
                @update:modelValue="addActiveRange"
                :enableTimePicker="false"
                v-model="lunches.active_range"
                :clearable="false"
                range
            />
            <WeekdaysChechkbox name="weekdays" />
            <ExtrasAndHolds holds="holds" extras="extras" />
            <BaseInput
                v-model="lunches.period_length"
                name="period_length"
                label="Period Length"
                type="number"
            />
            <label
                class="text-md flex font-bold text-gray-600 whitespace-normal"
                >Claimables
            </label>
            <Multiselect
                v-model="lunches.claimables"
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
                v-model="lunches.price_day"
                name="price_day"
                label="Price per day"
                type="number"
            />
            <BaseInput
                v-model="lunches.price_period"
                name="price_period"
                label="Price per period"
                type="number"
            />
            <Button text="Save Lunch" />
        </form>
    </div>
</template>

<script setup>
import { addYears, format, eachDayOfInterval } from "date-fns";
import { ref, onMounted } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import axios from "@/config/axios/index";
import BaseInput from "@/components/form-components/BaseInput.vue";
import Multiselect from "@vueform/multiselect";
import WeekdaysChechkbox from "@/components/lunch-managment/WeekdaysCechkbox.vue";
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import Button from "@/components/ui/Button.vue";
import { useRoute } from "vue-router";
const route = useRoute();
const id = parseInt(route.params.id);

const store = useLunchFormStore();

const multiselectRef = ref(null);
const lunches = ref("");
const errors = ref([]);

onMounted(() => {
    axios.get("/school/lunch/" + id).then((response) => {
        lunches.value = response.data.data;
    });
});

const updateLunch = async (id) => {
    try {
        await axios.put("/api/school/lunch/" + id, {
            title: store.title,
            description: store.description,
            period_length: store.period_length,
            weekdays: store.weekdays,
            active_range: [
                format(store.active_range[0], "yyyy-MM-dd"),
                format(store.active_range[1], "yyyy-MM-dd"),
            ],
            claimables: store.claimables,
            price_day: store.price_day,
            price_period: store.price_period,
            extras: store.extras,
            holds: store.holds,
        });

        store.extras = [];
        store.holds = [];
        store.disabled_hold_days = [];
        store.disabled_extra_days = [];
    } catch (e) {
        if (e.response.status === 422) {
            errors.value = e.response.data.errors;
        }
    }
};

const addActiveRange = (modelData) => {
    if (store.active_range.length < 2) {
        store.active_range.push(...modelData);
    } else {
        store.active_range.splice(0, 2, ...modelData);
    }

    const eachDay = eachDayOfInterval({
        start: modelData[0],
        end: modelData[1],
    });

    // format each day to YYYY-MM-DD'

    let formatedDate = [];

    for (let i = 0; i < eachDay.length; i++) {
        formatedDate.push(format(new Date(eachDay[i]), "yyyy-MM-dd"));
    }

    // if marked days doesnot contain any of the days in the range, remove all marked days

    if (store.marked_days.length > 0) {
        for (let i = 0; i < store.marked_days.length; i++) {
            if (!formatedDate.includes(store.marked_days[i])) {
                store.marked_days.splice(0, store.marked_days.length);
            }
        }
    }

    // if weekdays are selected and matched with each day of active range then add them to store
    eachDay.map((day) => {
        if (store.weekdays) {
            store.weekdays.map((weekday) => {
                if (weekday === format(day, "EEEE")) {
                    store.marked_days.push(format(day, "yyyy-MM-dd"));
                }
            });
        }
    });
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
