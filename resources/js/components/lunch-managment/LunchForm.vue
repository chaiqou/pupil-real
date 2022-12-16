<template>
    <div class="sm:mt-20 min-w-[30vw] xl:px-4">
        <form @submit.prevent="onSubmit">
            <p class="mb-2 text-center text-xl font-black">
                Create new lunch plan
            </p>
            <BaseInput
                v-model="store.title"
                name="Title"
                label="Title"
                rules="required|min:3|max:100"
            />
            <BaseInput
                v-model="store.description"
                inputType="textarea"
                name="Description"
                label="Description"
                rules="required|min:3|max:100"
            />
            <label
                class="text-md flex font-bold text-gray-600 whitespace-normal"
                >Active Range
            </label>
            <Datepicker
                closeOnScroll
                required
                :minDate="new Date()"
                :maxDate="addYears(new Date(), 1)"
                :partialRange="false"
                @update:modelValue="addActiveRange"
                :enableTimePicker="false"
                v-model="activeRange"
                :clearable="false"
                range
            />
            <WeekdaysChechkbox name="weekdays" />
            <ExtrasAndHolds holds="holds" extras="extras" />
            <BaseInput
                v-model="store.period_length"
                name="Period Length"
                label="Period Length"
                type="number"
                rules="required"
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
                name="Price per day"
                label="Price per day"
                type="number"
                rules="required"
            />
            <BaseInput
                v-model="store.price_period"
                name="Price per period"
                label="Price per period"
                type="number"
                rules="required"
            />
            <BaseInput
                v-model.number="store.buffer_time"
                name="buffer_time"
                label="Buffer time"
                type="number"
                rules="required|minNumber:1|maxNumber:72"
                placeholder="from 1 to 72 hours"
            />
            <Button text="Save Lunch" />
        </form>
        <Toast ref="childrenToast" />
    </div>
</template>

<script setup>
import { useForm } from "vee-validate";
import { addYears, format, eachDayOfInterval } from "date-fns";
import { ref } from "vue";
import { useLunchFormStore } from "@/stores/useLunchFormStore";

import axios from "@/config/axios/index";
import BaseInput from "@/components/form-components/BaseInput.vue";
import Multiselect from "@vueform/multiselect";
import WeekdaysChechkbox from "@/components/lunch-managment/WeekdaysCechkbox.vue";
import ExtrasAndHolds from "@/components/lunch-managment/ExtrasAndHolds.vue";
import Button from "@/components/ui/Button.vue";
import Toast from "@/components/ui/Toast.vue";

const store = useLunchFormStore();
const { handleSubmit } = useForm();

const multiselectRef = ref(null);
const activeRange = ref(null);
const childrenToast = ref();

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

const onSubmit = handleSubmit((values, { resetForm }) => {
    axios
        .post("/school/lunch", {
            title: store.title,
            description: store.description,
            period_length: store.period_length,
            weekdays: store.weekdays,
            active_range: [
                format(store.active_range[0], "yyyy-MM-dd"),
                format(store.active_range[1], "yyyy-MM-dd"),
            ],
            claimables: store.claimables,
            holds: store.holds,
            extras: store.extras,
            price_day: store.price_day,
            price_period: store.price_period,
            available_days: store.marked_days,
            buffer_time: store.buffer_time,
        })
        .then(() => {
            resetForm();
            multiselectRef.value.clear();
            childrenToast.value.showToaster("Lunch created successfully");
            setTimeout(() => {
                window.location.href = "/school/lunch-management/";
            }, 1000);
        });

    store.extras = [];
    store.holds = [];
    store.disabled_hold_days = [];
    store.disabled_extra_days = [];
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
