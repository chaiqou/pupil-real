<template>
    <div class="flex items-center justify-between">
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >Weekdays
        </label>
    </div>
    <div class="flex justify-center">
        <ul v-for="day in dayOptions" class="grid w-full md:grid-cols-3">
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
                    class="flex justify-between items-center p-5 w-full text-gray-500 bg-white rounded-lg border-2 border-gray-200 cursor-pointer peer-checked:bg-indigo-600 peer-checked:border-indigo-600 hover:text-gray-600 peer-checked:text-white hover:bg-gray-50"
                >
                    <div class="block">
                        <div class="w-full text-lg font-semibold">
                            {{ day.name }}
                        </div>
                    </div>
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
