<template>
    <div class="sm:mt-20 min-w-[30vw] xl:px-4">
        <form @submit.prevent="updateLunch(store.lunch_id)">
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
                :partial-range="true"
                range
                @update:modelValue="addActiveRange"
                v-model="store.active_range"
                :enableTimePicker="false"
                :clearable="false"
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
                                v-model="store.weekdays"
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
            <div
                class="flex max-h-screen flex-col justify-center overflow-hidden bg-inherit"
            >
                <label
                    class="text-md flex mt-2 font-bold text-gray-600 whitespace-normal"
                    >Extras and Holds
                </label>
                <div class="rounded-md bg-inherit">
                    <div class="mt-6 flow-root">
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            <li
                                v-for="(extra, extraIdx) in store.extras"
                                class="py-4"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-green-500"
                                        >
                                            <ExtrasIcon />
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p
                                            class="truncate text-sm font-medium text-gray-900"
                                        >
                                            Extra period
                                        </p>
                                        <p
                                            class="truncate text-sm text-gray-500"
                                        >
                                            {{ `${extra[0]} - ${extra[1]}` }}
                                        </p>
                                    </div>
                                    <div>
                                        <button
                                            type="button"
                                            @click="
                                                removeExtra(extraIdx, extra)
                                            "
                                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </li>
                            <li
                                v-for="(hold, holdIdx) in store.holds"
                                class="py-4"
                            >
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0">
                                        <span
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-red-500"
                                        >
                                            <HoldsIcon />
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <p
                                            class="truncate text-sm font-medium text-gray-900"
                                        >
                                            Hold period
                                        </p>
                                        <p
                                            class="truncate text-sm text-gray-500"
                                        >
                                            {{ `${hold[0]} - ${hold[1]}` }}
                                        </p>
                                    </div>
                                    <div>
                                        <button
                                            type="button"
                                            @click="removeHold(holdIdx, hold)"
                                            class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="mt-6 grid grid-cols-2 grid-rows-1 space-x-2">
                    <Datepicker
                        closeOnScroll
                        @update:modelValue="handleExtrasDate"
                        :disabledDates="[
                            ...store.disabled_hold_days,
                            ...store.disabled_extra_days,
                        ]"
                        :maxDate="addYears(new Date(), 1)"
                        range
                        :partial-range="false"
                        :minDate="new Date()"
                        :enableTimePicker="false"
                        no-disabled-range
                    >
                        <template #trigger>
                            <p
                                class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                            >
                                Add extra
                            </p>
                        </template>
                    </Datepicker>
                    <Datepicker
                        closeOnScroll
                        :minDate="new Date()"
                        :disabledDates="[
                            ...store.disabled_hold_days,
                            ...store.disabled_extra_days,
                        ]"
                        :partial-range="false"
                        range
                        :maxDate="addYears(new Date(), 1)"
                        @update:modelValue="handleHoldsDate"
                        :enableTimePicker="false"
                        no-disabled-range
                    >
                        <template #trigger>
                            <p
                                class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50"
                            >
                                Add holds
                            </p>
                        </template>
                    </Datepicker>
                </div>
            </div>
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
                :value="store.claimables"
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
                selectAll
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
            <ConfirmationModal v-if="isOpen" />
        </form>
    </div>
</template>

<script setup>
import { addYears, format, eachDayOfInterval, parseISO } from "date-fns";
import { ref, onMounted } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { useRoute } from "vue-router";
import { Field, ErrorMessage, useForm } from "vee-validate";

import axios from "@/config/axios/index";
import BaseInput from "@/components/form-components/BaseInput.vue";
import Multiselect from "@vueform/multiselect";
import Button from "@/components/ui/Button.vue";
import ExtrasIcon from "../icons/ExtrasIcon.vue";
import HoldsIcon from "../icons/HoldsIcon.vue";
import ConfirmationModal from "../lunch-managment/ConfirmationModal.vue";

// Composables

const store = useLunchFormStore();
const route = useRoute();
const { handleSubmit } = useForm();

// Data

const multiselectRef = ref(null);
const isOpen = ref(true);

// Fetch appropriate lunch from API

const id = parseInt(route.params.id);

onMounted(() => {
    axios.get("/school/lunch/" + id).then((response) => {
        store.title = response.data.data.title;
        store.description = response.data.data.description;
        store.period_length = response.data.data.period_length;
        store.weekdays = response.data.data.weekdays;
        store.active_range = response.data.data.active_range;
        store.claimables = response.data.data.claimables;
        store.price_day = response.data.data.price_day;
        store.price_period = response.data.data.price_period;
        store.extras = response.data.data.extras;
        store.holds = response.data.data.holds;
        store.lunch_id = response.data.data.id;
    });
});

// Update lunch part

const updateLunch = handleSubmit((lunch, { resetForm }) => {
    console.log(lunch);
    axios
        .put("/school/lunch/" + store.lunch_id, {
            title: store.title,
            description: store.description,
            period_length: store.period_length,
            weekdays: store.weekdays,
            active_range: store.active_range,
            claimables: store.claimables,
            price_day: store.price_day,
            price_period: store.price_period,
            extras: store.extras,
            holds: store.holds,
        })
        .then((response) => {
            resetForm();
            store.extras = [];
            store.holds = [];
            store.disabled_hold_days = [];
            store.disabled_extra_days = [];
        });
});

// Extras part

const removeExtra = (extraIdx, extra) => {
    store.extras.splice(extraIdx, 1);

    let dates = [];
    let startDate = new Date(extra[0]);
    let endDate = new Date(extra[1]);

    while (startDate <= endDate) {
        dates.push(new Date(startDate));
        startDate.setDate(startDate.getDate() + 1);
    }

    let formattedDates = dates.map((date) => format(date, "yyyy-MM-dd"));

    store.formatDateForHumans("disabled_extra_days", store.disabled_extra_days);

    store.disabled_extra_days = store.disabled_extra_days.filter(
        (date) => !formattedDates.includes(date)
    );

    store.removeDaysFromMarkedDays(extra);

    store.add_marked_extras = [];
};

const handleExtrasDate = (modelData) => {
    store.extras.push([
        format(modelData[0], "yyyy-MM-dd"),
        format(modelData[1], "yyyy-MM-dd"),
    ]);

    store.disabledDaysDate(modelData[0], modelData[1]).forEach((data) => {
        store.disabled_extra_days.push(data);
    });

    // add extras to marked days

    store.findMiddleRangeDates("add_extras", store.extras);
    let deUnique = store.add_marked_extras;
    let uniqueValues = new Set(deUnique);
    deUnique = Array.from(uniqueValues);

    store.remove_marked_holds.map((hold) => {
        if (deUnique.includes(hold)) {
            deUnique.splice(deUnique.indexOf(hold), 1);
        }
    });

    deUnique.map((extra) => {
        if (!store.marked_days.includes(extra)) {
            store.marked_days.push(extra);
        }
    });
};

// Holds Part

const removeHold = (holdIdx, hold) => {
    store.holds.splice(holdIdx, 1);

    let dates = [];
    let startDate = new Date(hold[0]);
    let endDate = new Date(hold[1]);

    while (startDate <= endDate) {
        dates.push(format(new Date(startDate), "yyyy-MM-dd"));
        startDate.setDate(startDate.getDate() + 1);
    }

    store.marked_days = [...store.marked_days, ...dates];

    store.formatDateForHumans("disabled_hold_days", store.disabled_hold_days);

    store.disabled_hold_days = store.disabled_hold_days.filter(
        (date) => !dates.includes(date)
    );
};

const handleHoldsDate = (modelData) => {
    store.holds.push([
        format(modelData[0], "yyyy-MM-dd"),
        format(modelData[1], "yyyy-MM-dd"),
    ]);

    store.disabledDaysDate(modelData[0], modelData[1]).forEach((date) => {
        store.disabled_hold_days.push(date);
    });

    // Remove holds from marked days

    store.findMiddleRangeDates("remove_holds", store.holds);
    let daysToDelete = new Set(store.remove_marked_holds);

    store.add_marked_extras.map((extra) => {
        if (daysToDelete.has(extra)) {
            daysToDelete.delete(extra);
        }
    });

    const removedDaysArray = store.marked_days.filter((day) => {
        return !daysToDelete.has(day);
    });

    store.marked_days = removedDaysArray;
};

// Weekdays part

const toggleWeekdays = (day) => {
    let eachDay = [];

    if (store.active_range !== null) {
        eachDay = eachDayOfInterval({
            start: parseISO(store.active_range[0]),
            end: parseISO(store.active_range[1]),
        });
    }

    eachDay.map((date) => {
        if (
            date.getDay() === day.index &&
            store.weekdays.includes(day.fullName)
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

// Active range part

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

// Multiselect options and styles

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
