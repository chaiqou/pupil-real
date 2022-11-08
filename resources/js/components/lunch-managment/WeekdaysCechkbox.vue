<template>
    <label class="text-md flex font-bold text-gray-600 whitespace-normal"
        >Weekdays
    </label>
    <div
        class="flex items-center pl-4 rounded border border-gray-200 dark:border-gray-700"
    >
        <Field
            name="weekdays"
            type="checkbox"
            value="Monday"
            rules="required"
            id="Monday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Monday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >M</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Tuesday"
            rules="required"
            id="Tuesday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Tuesday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >T</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Wednesday"
            rules="required"
            id="Wednesday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Wednesday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >W</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Thuersday"
            rules="required"
            id="Thuersday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Thuersday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >T</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Friday"
            rules="required"
            id="Friday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Friday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >F</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Saturday"
            rules="required"
            id="Saturday"
            class="w-4 text-indigo-600 bg-white rounded border-gray-300 focus:ring-indigo-500"
        />
        <label
            for="Saturday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >S</label
        >
        <Field
            name="weekdays"
            type="checkbox"
            value="Sunday"
            rules="required"
            id="Sunday"
            class="w-4 text-blue-600 bg-white rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
        />
        <label
            for="Sunday"
            class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300"
            >S</label
        >
    </div>
    <span class="mt-2 text-sm text-red-500 whitespace-nowrap">
        <ErrorMessage name="weekdays" />
    </span>
</template>

<script setup>
import { Field, ErrorMessage } from "vee-validate";
</script>
