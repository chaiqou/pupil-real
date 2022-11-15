<template>
    <label class="text-md font-bold text-gray-600">Weekdays</label>
    <div class="grid grid-cols-3 gap-3 sm:grid-cols-6 text-center">
        <ul v-for="day in dayOptions">
            <li>
                <Field
                    name="weekdays"
                    type="checkbox"
                    :value="day.fullName"
                    v-model="store.tags"
                    rules="required"
                    :id="day.fullName"
                    class="hidden peer"
                />
                <label
                    :for="day.fullName"
                    class="flex items-center text-left text-md font-semibold px-3 py-2 xl:w-full text-gray-500 bg-white rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:ring-2 peer-checked:ring-offset-2 peer-checked:ring-indigo-500 hover:text-gray-600 peer-checked:text-white hover:bg-gray-50"
                >
                    {{ day.name }}
                </label>
            </li>
        </ul>
    </div>
    <span class="mt-2 text-sm text-red-500">
        <ErrorMessage name="weekdays" />
    </span>
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";
import { useLunchFormStore } from "../../stores/useLunchFormStore";

const store = useLunchFormStore();

const dayOptions = [
    { name: "M", fullName: "monday", validOption: true },
    { name: "T", fullName: "tuesday", validOption: true },
    { name: "W", fullName: "wednesday", validOption: true },
    { name: "T", fullName: "thursday", validOption: true },
    { name: "F", fullName: "friday", validOption: true },
    { name: "S", fullName: "saturday", validOption: true },
    { name: "S", fullName: "sunday", validOption: true },
];
</script>
