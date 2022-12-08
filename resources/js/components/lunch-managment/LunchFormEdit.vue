<template>
    <div class="sm:mt-20 min-w-[30vw] xl:px-4">
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
            <div>
                <label class="text-md font-bold text-gray-600">Weekdays</label>
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-7 text-center">
                    <ul v-for="day in dayOptions">
                        <li>
                            <Field
                                name="weekdays"
                                type="checkbox"
                                :value="day.fullName"
                                @input="toggleWeekdays(day)"
                                rules="required"
                                :id="day.fullName"
                                class="hidden peer"
                                v-model="lunches.weekdays"
                            />
                            <label
                                :for="day.fullName"
                                class="flex items-center text-left text-md font-semibold px-3 py-2 xl:w-full text-gray-500 bg-white rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 hover:text-gray-600 peer-checked:text-white hover:bg-gray-50"
                            >
                                <h1
                                    class="flex text-center mx-auto md:-mx-1 lg:mx-auto"
                                >
                                    {{ day.name }}
                                </h1>
                            </label>
                        </li>
                    </ul>
                </div>
                <span class="mt-2 text-sm text-red-500">
                    <ErrorMessage name="weekdays" />
                </span>
            </div>
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
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import Button from "@/components/ui/Button.vue";
import { useRoute } from "vue-router";
import { Field, ErrorMessage } from "vee-validate";

const store = useLunchFormStore();

const toggleWeekdays = (day) => {
    const eachDay = eachDayOfInterval({
        start: store.active_range[0],
        end: store.active_range[1],
    });

    eachDay.map((date) => {
        if (
            date.getDay() === day.index &&
            store.weekdays.includes(day.fullName) &&
            store.holds.length === 0
        ) {
            store.marked_days.push(format(new Date(date), "yyyy-MM-dd"));
        } else if (
            date.getDay() === day.index &&
            !store.weekdays.includes(day.fullName)
        ) {
            let filteredDays = store.marked_days.filter(
                (item) => item !== format(new Date(date), "yyyy-MM-dd")
            );
            store.marked_days = [...filteredDays, ...store.add_marked_extras];
        }
    });
};

const dayOptions = [
    { name: "M", fullName: "Monday", index: 1 },
    { name: "T", fullName: "Tuesday", index: 2 },
    { name: "W", fullName: "Wednesday", index: 3 },
    { name: "T", fullName: "Thursday", index: 4 },
    { name: "F", fullName: "Friday", index: 5 },
    { name: "S", fullName: "Saturday", index: 6 },
    { name: "S", fullName: "Sunday", index: 0 },
];
const route = useRoute();
const id = parseInt(route.params.id);

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
