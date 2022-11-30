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
                        v-model="store.weekdays"
                        rules="required"
                        :id="day.fullName"
                        class="hidden peer"
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
import { onUpdated } from "vue";

onUpdated(() => {
    store.weekdaysMatch();
});

const store = useLunchFormStore();

const dayOptions = [
    { name: "M", fullName: "Monday", validOption: true },
    { name: "T", fullName: "Tuesday", validOption: true },
    { name: "W", fullName: "Wednesday", validOption: true },
    { name: "T", fullName: "Thursday", validOption: true },
    { name: "F", fullName: "Friday", validOption: true },
    { name: "S", fullName: "Saturday", validOption: true },
    { name: "S", fullName: "Sunday", validOption: true },
];
</script>
