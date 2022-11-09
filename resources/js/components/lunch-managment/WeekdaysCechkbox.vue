<template>
    <div class="flex items-center justify-between">
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >Weekdays
        </label>
    </div>
    <div class="lg:flex xl:space-x-6 justify-center">
        <ul v-for="day in dayOptions">
            <li>
                <Field
                    name="weekdays"
                    type="checkbox"
                    :value="day.fullName"
                    rules="required"
                    :id="day.fullName"
                    class="hidden peer"
                />
                <label
                    :for="day.fullName"
                    class="flex items-center text-left text-md font-semibold px-5 py-5 xl:w-full text-gray-500 bg-white rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:bg-indigo-600 peer-checked:border-indigo-600 hover:text-gray-600 peer-checked:text-white hover:bg-gray-50"
                >
                    {{ day.name }}
                </label>
            </li>
        </ul>
    </div>
    <span class="mt-2 text-sm text-red-500 whitespace-nowrap">
        <ErrorMessage name="weekdays" />
    </span>
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";

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
