<template>
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
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";
import { useLunchFormStore } from "@/stores/useLunchFormStore";
import { format } from "date-fns";

const store = useLunchFormStore();

const toggleWeekdays = (day) => {
    store.findMiddleRangeDates("toggle_based_weekdays", store.active_range);

    store.toggle_based_weekdays.map((date) => {
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
</script>
