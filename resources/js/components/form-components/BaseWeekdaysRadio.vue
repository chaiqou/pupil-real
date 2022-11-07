<template>
    <div>
        <label class="text-md flex font-bold text-gray-600 whitespace-normal"
            >{{ label }}
        </label>
        <RadioGroup v-model="value" class="mt-2">
            <div class="grid grid-cols-3 gap-2 sm:grid-cols-6">
                <RadioGroupOption
                    as="template"
                    v-for="option in dayOptions"
                    :key="option.name"
                    :value="option.fullName"
                    :disabled="!option.validOption"
                    v-slot="{ active, checked }"
                >
                    <div
                        :class="[
                            option.validOption
                                ? 'cursor-pointer focus:outline-none'
                                : 'opacity-25 cursor-not-allowed',
                            active
                                ? 'ring-2 ring-offset-2 ring-indigo-500'
                                : '',
                            checked
                                ? 'bg-indigo-600 border-transparent text-white hover:bg-indigo-700'
                                : 'bg-white border-gray-200 text-gray-900 hover:bg-gray-50',
                            'border rounded-md flex flex-nowrap items-center justify-center text-sm font-medium uppercase py-3 px-3 sm:flex-1',
                        ]"
                    >
                        <RadioGroupLabel as="span">{{
                            option.name
                        }}</RadioGroupLabel>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>
        <span class="mt-2 text-sm text-red-500 whitespace-nowrap">{{
            errorMessage
        }}</span>
    </div>
</template>

<script setup>
import { useField } from "vee-validate";
import { defineProps, toRef } from "vue";
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from "@headlessui/vue";

const dayOptions = [
    { name: "M", fullName: "monday", validOption: true },
    { name: "T", fullName: "tuesday", validOption: true },
    { name: "W", fullName: "wednesday", validOption: true },
    { name: "T", fullName: "thursday", validOption: true },
    { name: "F", fullName: "friday", validOption: true },
    { name: "S", fullName: "saturday", validOption: true },
    { name: "S", fullName: "sunday", validOption: true },
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
