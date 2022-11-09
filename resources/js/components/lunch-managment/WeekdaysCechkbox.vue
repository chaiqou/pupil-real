<template>
    <label class="text-md flex font-bold text-gray-600 whitespace-normal"
        >Weekdays
    </label>
    <div
        v-for="day in dayOptions"
        class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700"
    >
        <Field
            name="weekdays"
            type="checkbox"
            :value="day.fullName"
            rules="required"
            :id="day.fullName"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            :for="day.fullName"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >{{ day.name }}</label
        >
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
