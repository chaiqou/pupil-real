<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-wrap"
            >{{ label }}
        </label>
        <fieldset>
            <div class="grid grid-cols-4 sm:grid-cols-6">
                <div v-for="(day, dayIdx) in dayOptions" :key="dayIdx">
                    <div
                        :class="[
                            day.validOption
                                ? 'cursor-pointer focus:outline-none'
                                : 'opacity-25 cursor-not-allowed',
                            'border w-full h-full rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase sm:flex-1',
                        ]"
                    >
                        <label
                            :for="day.id"
                            class="select-none font-medium text-gray-700"
                            >{{ day.name }}</label
                        >
                        <div class="ml-3 flex h-full items-center">
                            <input
                                v-model="value"
                                :value="day.fullName"
                                :name="day.fullName"
                                type="checkbox"
                                class="h-4 w-4 rounded border-gray-300 whitespace-normal text-indigo-600 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </fieldset>
        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{
            errorMessage
        }}</span>
    </div>
</template>

<script setup>
import { useField } from "vee-validate";
import { defineProps, toRef, ref } from "vue";

const technology = ref([]);

const dayOptions = [
    { id: 1, name: "M", fullName: "monday", validOption: true },
    { id: 2, name: "T", fullName: "tuesday", validOption: true },
    { id: 3, name: "W", fullName: "wednesday", validOption: true },
    { id: 4, name: "T", fullName: "thursday", validOption: true },
    { id: 5, name: "F", fullName: "friday", validOption: true },
    { id: 6, name: "S", fullName: "saturday", validOption: true },
    { id: 7, name: "S", fullName: "sunday", validOption: true },
];

const props = defineProps({
    name: {
        type: String,
        required: true,
    },
    label: {
        type: String,
        required: true,
    },
});

function required(value) {
    if (value) {
        return true;
    }
    return "This field is required";
}

const nameRef = toRef(props, "name");
const { errorMessage, value } = useField(nameRef, required);
</script>
